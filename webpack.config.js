const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
    entry: './templates/assets/js/main.js',
    output: {
        filename: 'main.min.js',
        path: path.resolve(__dirname, './templates/assets/dist')
    },
    watch: true,
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [{
                    loader: "style-loader"
                }, {
                    loader: "css-loader"
                }, {
                    loader: "sass-loader",
                    options: {
                        includePaths: ["absolute/path/a", "absolute/path/b"]
                    }
                }]
            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                use: [
                    'file-loader'
                ]
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    'file-loader'
                ]
            }
        ]
    },
    plugins: [
        new BrowserSyncPlugin({
            host: 'localhost',
            port: 3000,
            files: [
                '../templates/**/**/*.scss',
                '../templates/**/**/*.html',
                '../templates/**/**/*.twig',
                '../templates/**/**/*.js'
            ],
            proxy: 'http://local.craft-3-test.nl'
        })
    ]
};