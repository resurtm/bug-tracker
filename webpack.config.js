var path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: [
        'babel-polyfill',
        './app/Resources/public/less/main.less',
        './app/Resources/public/js/main.js',
        'webpack-dev-server/client?http://localhost:8090'
    ],
    output: {
        publicPath: '/',
        filename: './web/main.js'
    },
    debug: true,
    devtool: 'source-map',
    module: {
        loaders: [
            {
                test: /\.js$/,
                include: path.join(__dirname, './app/Resources/public/js/'),
                loader: 'babel-loader',
                query: {
                    presets: ['es2015']
                }
            },
            {
                test: /\.less$/,
                loader: "style!css!autoprefixer!less"
            },
        ]
    },
    devServer: {
        contentBase: './app/Resources/public/'
    }
};
