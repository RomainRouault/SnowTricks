var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addStyleEntry('css/app', './assets/js/app-style.js')
    .addEntry('js/app', './assets/js/app-js.js')

    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()

    // disable UrlResolver in order to fix slowdown of the webpack build caused by Bootstrap import
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })

    .enableBuildNotifications()
;

module.exports = Encore.getWebpackConfig();