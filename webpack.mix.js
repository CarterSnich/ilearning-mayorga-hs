const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css")
    .css("resources/css/index.css", "public/css")
    .css("resources/css/teacher-layout.css", "public/css")
    .css("resources/css/teacher-classes.css", "public/css")
    .css("resources/css/teacher-class.css", "public/css")
    .css("resources/css/teacher-class-class.css", "public/css")
    .css("resources/css/teacher-create-activity.css", "public/css")
    .css("resources/css/teacher-view-activity.css", "public/css")
    .css("resources/css/student-classes.css", "public/css")
    .css("resources/css/student-class.css", "public/css")
    .css("resources/css/student-layout.css", "public/css")
    .css("resources/css/student-view-activity.css", "public/css")
    .css("resources/css/administrator-layout.css", "public/css")
    .disableSuccessNotifications();
