var path     = require('path');
var minimist = require('minimist');
var arg      = minimist(process.argv.slice(2));

var THEME_NAME = "skelton";
var THEME_DIR  = path.resolve(__dirname, '../' + THEME_NAME);
var src        = './assets';  // ソースディレクトリ

var SpritesmithPlugin = require('webpack-spritesmith');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var autoprefixer      = require("autoprefixer");

module.exports = [{
    entry: {
      'pc' : src + '/javascripts/pc/app.js',
      'sp' : src + '/javascripts/sp/app.js',
    },
    output: {
        filename: 'bundle.[name].js',
        path: THEME_DIR + '/javascripts/'
    }
  },{
    entry: {
      'pc' : src + '/stylesheets/pc/style.scss',
      'sp' : src + '/stylesheets/sp/style.scss',
    },
    output: {
      filename: 'style.[name].css',
      path: THEME_DIR + '/stylesheets'
    },
    module: {
      rules: [
        {
          test: /\.(css|scss)$/,
          use: ExtractTextPlugin.extract(
            {
              fallback: "style-loader",
              use: [
                "css-loader", {
                    loader: 'postcss-loader',
                    options: {
                      plugins: function () {
                        return [
                            require('autoprefixer')
                        ];
                      }
                    }
                },
                "sass-loader?outputStyle=expanded"
              ]
            }
          )
        }
      ]
    },
    plugins: [
      new ExtractTextPlugin({
          filename: 'style.[name].css',
          allChunks: false
      })
    ]
  }
];
