process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
var b = require('./src/gulp/index.js');
require('laravel-elixir-lost');
require('laravel-elixir-sass-compass');
require('laravel-elixir-postcss');
// require('laravel-elixir-browser-sync-simple');

elixir.config.assetsPath = './src';

b.processConfigFile('config.json');
b.processArguments();
b.loadConfigs({
    'cms': 'cms.json',
    'frontend': 'frontend.json'
});

elixir(function(mix) {

    Object.keys(b.paths).forEach(function(i) {
        Object.keys(b.paths[i]).forEach(function(j) {
            var item = b.paths[i][j],
                type = item.type,
                src = item.src,
                output = item.output;

            if (!b.preProcess(item)) {
                return;
            }

            if (type == 'sassLost')
                mix.sassLost(src, output);

            if (type == 'sass')
                mix.sass(src, output);

            if (type === 'compass') {
                mix.compass(src, output, {
                    style: 'compressed',
                    sass: './src/sass',
                    sourcemap: elixir.config.sourcemaps
                });
            }

            if (type == 'sassLost' || type == 'sass' || type == 'compass')
                mix.postcss(output, {
                    plugins:[
                        require('postcss-nested')
                    ]
                });

            if (type == 'js')
                mix.scripts(src, output);

            if (type == 'copy')
                mix.copy(src, output);
        });
    });

    if (b.config.sync) {
        mix.browserSync({
            files: [
                './app/**/*',
                './public/css/**/*',
                './public/js/**/*',
                './public/cms/**/*'
            ],
            proxy: b.config.syncDomain,
            startPath: b.config.syncStartPath,
            logPrefix: 'Laravel Eixir BrowserSync',
            logConnections: false,
            reloadOnRestart: false,
            notify: false,
            open: false
        });
    }
});

elixir.config.css.autoprefix.options.browsers = ['> 1%', 'Last 2 versions', 'IE 9'];