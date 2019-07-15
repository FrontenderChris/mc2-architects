cl = console.log;
var fs = require('fs');
var gutils = require('gulp-util');
var elixir = require('laravel-elixir');
var _ = require('underscore');


var Bpb = {};
Bpb.config = {};
Bpb.paths = {};

Bpb.readJson = function(file) {
    var json;
    var relativePath = __dirname + '/' + file;
    if (fs.existsSync(relativePath)) {
        try {
            var jsonlint = require('jsonlint');
            json = fs.readFileSync(relativePath, 'utf8');
            jsonlint.parse(json);
        } catch (e) {
            cl(relativePath, e);
        }
    } else {
        cl(relativePath + ' does not exist');
    }
    return JSON.parse(json);
};

Bpb.setPaths = function(name, file) {
    this.paths[name] = Bpb.readJson(file);
};


Bpb.forEach = function(o, cb) {
    var counter = 0,
        keys = Object.keys(o),
        len = keys.length;
    var next = function() {
        if (counter < len) cb(o[keys[counter++]], next);
    };
    next();
};

Bpb.log = function() {
    if (this.verbose) {
        var messages = [];
        for (var i = 0; i < arguments.length; i++) {
            messages.push(arguments[i].toString());
        }
        cl(gutils.colors.blue(messages.join(', ')));
    }
};



Bpb.processConfigFile = function(file) {
    Bpb.config = Bpb.readJson(file);
};

Bpb.processArguments = function(arg) {
    Object.keys(gutils.env).forEach(function(key) {
        if (key != '_') {
            Bpb.config[key] = gutils.env[key];
        }
    });

    // do some extra processing
    if (Bpb.config.silent) {
        console.log = function() {};
    }
};

// Bpb.ignoreItem = function(item) {
//     if (item.type == 'sass' && this.config.css) return true;
// };

Bpb.loadConfigs = function(data) {
    Object.keys(data).forEach(function(key) {
        var item = data[key];
        if (Bpb.config[key]) {
            // key is 'frontend' or 'cms' -- only load the json if config allows
            Bpb.setPaths(key, data[key]);
        }
    });
};


Bpb.preProcess = function(item) {
    if (item.type == 'sass' && !Bpb.config.css) return false;
    if (item.type == 'styles' && !Bpb.config.css) return false;
    if (item.type == 'compass' && !Bpb.config.css) return false;
    if (item.type == 'sassLost' && !Bpb.config.css) return false;
    if (item.type == 'js' && !Bpb.config.js) return false;
    if (item.plugins && !Bpb.config.plugins) return false;
    elixir.config.sourcemaps = Bpb.sourcemaps(item) === true || Bpb.config.sourcemaps;
    return true;
};

Bpb.sourcemaps = function(item) {
    if (item.sourcemaps === false) {
        return false;
    }
    return item.sourcemaps === true || Bpb.config.sourcemaps || elixir.config.production;
};



module.exports = Bpb;
