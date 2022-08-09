const HtmlWebpackPlugin = require('html-webpack-plugin')
const path = require('path')

module.exports = {
    entry: './src/index.js',
    module: {
        rules: [
            {test: /\.(js)$/, use: 'babel-loader'}
        ]
    }, output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'index_bundle.js'
    },
    // plugins: [
    //     new HtmlWebpackPlugin()
    // ],
    mode: "production" //production | development
}