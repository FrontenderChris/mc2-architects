@extends('layouts.app')

@section('content')
    <section role="main" class="main">
        <section class="body-container">
            <div class="content-max-width">
                @if (!empty($sentryID) && env('SENTRY_POPUP_ENABLE', false))
                    <!-- Sentry JS SDK 2.1.+ required -->
                    <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>
                    <script>
                        Raven.showReportDialog({
                            eventId: '{{ $sentryID }}',
                            dsn: '{{ env('SENTRY_PUBLIC_DSN') }}'
                        });
                    </script>
                @endif
                <h2>Whoops, Something Went Wrong!</h2>
                <p><strong>It looks like we're having some internal issues.</strong></p>
                <p>Our team has been notified of the issue.</p>
            </div>
        </section>
    </section>
@endsection