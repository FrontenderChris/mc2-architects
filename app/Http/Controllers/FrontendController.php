<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\ContactEntry;
use App\Models\Settings;
use App\Models\ProjectCategory;
use Modulatte\Pages\Models\Page;

class FrontendController extends Controller
{
    const PAGINATE_LIMIT = 10;

    /**
     * If {page} exists in /pages dir in /views.
     *
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug)
    {
        $page = Page::with('image', 'seo')->where('slug', '=', $slug)->firstOrFail();

        return view('pages.'.$slug, compact('page'))->with('seo', $page->seo);
    }

    /**
     * @return $this
     */
    public function home()
    {
        $page = Page::with('seo', 'images')->where('slug', '=', 'home')->firstOrFail();
        $subPages = Page::where('parent_id', 6 )->where('data','like', '%"featured":"on"%')->get();
        
        return view('pages.home', compact('page'), compact('subPages') )
        ->with('seo', $page->seo);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    // public function contact()
    // {
    //     $model = Page::with('seo')->where('slug', '=', 'contact')->first();

    //     return view('pages.contact', compact('model'))
    //         ->with('seo', $model->seo);
    // }

    /**
     * @param ContactFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactSend(ContactFormRequest $request)
    {
        $entry = ContactEntry::create($request->all());

        app('Illuminate\Mail\Mailer')->send('mail.contact', compact('entry'), function($mail) use ($entry, $request){
            $mail->from(settings('email_from'), settings('site_name'));
            $mail->to(settings('email_to'));
            $mail->replyTo($entry->email);
            $mail->subject($request->get('subject')?$request->get('subject'): 'Contact Form Enquiry');
        });

        return redirect()->route('page', 'contact-us')
            ->with('success-msg', 'Your enquiry has been sent.');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projects()
    {
        $model = Page::with('seo')->where('slug', '=', 'projects')->firstOrFail();
        $subPages = Page::with('categories')->where('parent_id', $model->id )->paginate(30);
        $categories = ProjectCategory::all();

        return view('pages.projects', compact('model','categories'), compact('subPages') )
            ->with('seo', $model->seo);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function project($project)
    {
        $model = Page::with('seo')->where('slug', '=', $project)->first();
        $page = Page::where('parent_id', $model->parent_id )->get();

        return view('pages.project-detail', compact('model'), compact('page'))
            ->with('seo', $model->seo);
    }

    /**
     * @param $page
     * @return bool
     */
    private function checkFileExists($page)
    {
        return \File::exists(resource_path('views/pages/') . $page . '.blade.php');
    }
}
