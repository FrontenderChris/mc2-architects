<?php
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    protected $simpleHtml = '
		<h2>Maecenas sed <strong>diam</strong> eget</h2>
		<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Aenean lacinia bibendum nulla sed consectetur. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
		<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vestibulum id ligula porta felis euismod semper.</p>
		<h3>Sub-Heading</h3>
		<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Sed posuere consectetur est at lobortis. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla vitae elit libero, a pharetra augue. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.<br>Sed posuere consectetur est at lobortis. Etiam porta sem malesuada magna mollis euismod. Nulla vitae elit libero, a pharetra augue. Sed posuere consectetur est at lobortis.</p>
		<p><br></p>
		<h2>Fusce dapibus, tellus ac cursus commodo</h2>
		<p>Nulla vitae elit libero, a pharetra augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vitae elit libero, a pharetra augue. Nullam quis risus eget urna mollis ornare vel eu leo. Curabitur blandit tempus porttitor. Cras mattis consectetur purus sit amet fermentum. Donec ullamcorper nulla non metus auctor fringilla.</p>
		<p><br>Cras mattis consectetur purus sit amet fermentum. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Donec sed odio dui. Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna.<br>Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas faucibus mollis interdum. Cras mattis consectetur purus sit amet fermentum. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!page($as = 'terms')) {
            factory(\Modulatte\Pages\Models\Page::class, $as)->create();
        }

        if (!page($as = 'privacy')) {
            factory(\Modulatte\Pages\Models\Page::class, $as)->create();
        }

        if (!page($as = 'about-us')) {
            $page = factory(\Modulatte\Pages\Models\Page::class, $as)->create();
            // Example image
            // $page->image()->save(fakeImage(400, 400, 'test'));
        }
    }
}
