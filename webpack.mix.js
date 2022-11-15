const mix = require('laravel-mix');


const glob = require('glob')
const path = require('path')


function mixAssetsDir(query, cb) {;
    (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/')
        cb(f, f.replace('resources', 'public'))
    })
}

mix.copyDirectory('resources/images', 'public/images')

// script vendor js
mixAssetsDir('js/vendor/*.js', (src, dest) => mix.scripts(src, dest))

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
