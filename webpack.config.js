var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')
    .createSharedEntry('app', ["./assets/scss/layout.scss","./assets/js/app.js"])
    .addEntry('home_js', ["./assets/js/slider/jssor_slider.min.js", "./assets/js/slider/slider.js", "./assets/js/home.js"])
    .addStyleEntry('home', "./assets/scss/home.scss")
    .addStyleEntry('teams', "./assets/scss/teams.scss")
    .addStyleEntry('players', "./assets/scss/players.scss")
    .addStyleEntry('bray_forges', "./assets/scss/bray_forges.scss")
    .addStyleEntry('trainings', "./assets/scss/trainings.scss")
    .addStyleEntry('results',"./assets/scss/results.scss")
    .addStyleEntry('gallery',"./assets/scss/gallery.scss")
    .addStyleEntry('album',"./assets/scss/album.scss")
    .addEntry('masonry',"./node_modules/masonry-layout/dist/masonry.pkgd.js")
    .addStyleEntry('blog',"./assets/scss/blog.scss")
    .addStyleEntry('article',"./assets/scss/article.scss")
    .addStyleEntry('contact',"./assets/scss/contact.scss")
    .enableSassLoader(function(sassOptions) {
        sassOptions.includePaths = ["assets/scss", "assets/css"];
    })
    .enableReactPreset()
    .cleanupOutputBeforeBuild()
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })
    .autoProvidejQuery()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;
module.exports = Encore.getWebpackConfig();
