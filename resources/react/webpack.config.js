const path = require("path");
const webpack = require("webpack");
const resolve = require('resolve');

const HtmlWebpackPlugin = require('html-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const InlineChunkHtmlPlugin = require('react-dev-utils/InlineChunkHtmlPlugin');
const InterpolateHtmlPlugin = require('react-dev-utils/InterpolateHtmlPlugin');
const ModuleNotFoundPlugin = require('react-dev-utils/ModuleNotFoundPlugin');
const getCSSModuleLocalIdent = require('react-dev-utils/getCSSModuleLocalIdent');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FileManagerPlugin = require('filemanager-webpack-plugin');

// style files regexes
const cssRegex = /\.css$/;
const cssModuleRegex = /\.module\.css$/;

// file names
const bundleJSfileName  = "bundle.min.js";
const bundleCSSfileName = "bundle.min.css";
const bundlesDir        = 'bundles';

//relative to this direcotry
const publicJSpath      = '../../public/js/react/';

// common function to get style loaders
const getStyleLoaders = (cssOptions, preProcessor) => {
    const loaders = [
    {
        loader: MiniCssExtractPlugin.loader,
        options: {},
    },
    {
        loader: require.resolve('css-loader'),
        options: cssOptions,
    },
    {
        loader: require.resolve('postcss-loader'),
        options: {
            postcssOptions: {
                ident: 'postcss',
                config: false,
                plugins: [
                    'postcss-flexbugs-fixes',
                    [
                        'postcss-preset-env',
                        {
                            autoprefixer: {
                                flexbox: 'no-2009',
                            },
                            stage: 3
                        }
                    ],
                    'postcss-normalize',
                ]
            },
            sourceMap: false,
        }
    }
    ].filter(Boolean);

    if (preProcessor) {
        loaders.push(
            {
                loader: require.resolve('resolve-url-loader'),
                options: {
                    sourceMap: false,
                    root: paths.appSrc,
                }
            },
            {
                loader: require.resolve(preProcessor),
                options: {
                    sourceMap: false,
                }
            }
        );
    }
    
    return loaders;
};

module.exports = {
    target: ['web'],
    mode : 'production',
    bail : false,
    devtool : 'source-map',
    entry : "./src/index.js",
    output: {
        path :    path.join(__dirname, bundlesDir),
        pathinfo: false,
        filename : bundleJSfileName,
        publicPath: './'
    },
    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    parse: {
                        ecma: 8,
                    },
                    compress: {
                        ecma: 5,
                        warnings: false,
                        comparisons: false,
                        inline: 2,
                    },
                    mangle: {
                        safari10: true,
                    },
                    keep_classnames: true,
                    keep_fnames: true,
                    output: {
                        ecma: 5,
                        comments: false,
                        ascii_only: true
                    }
                }
            }),
            new CssMinimizerPlugin(),
        ]
    },
    module: {
        strictExportPresence: true,
        rules: [
            {
                oneOf: [
                    {
                        test: /\.(js|mjs|jsx|ts|tsx)$/,
                        include: path.join(__dirname, 'src'),
                        loader: require.resolve('babel-loader'),
                        options: {
                            customize: require.resolve(
                                'babel-preset-react-app/webpack-overrides'
                            ),
                            presets: [
                                [
                                    require.resolve('babel-preset-react-app'),
                                    {
                                        runtime: 'classic'
                                    }
                                ]
                            ],
                            babelrc: false,
                            configFile: false,
                            cacheDirectory: true,
                            cacheCompression: false,
                            compact: false
                        }
                    },
                    {
                        test: /\.(js|mjs)$/,
                        exclude: /@babel(?:\/|\\{1,2})runtime/,
                        loader: require.resolve('babel-loader'),
                        options: {
                            babelrc: false,
                            configFile: false,
                            compact: false,
                            presets: [
                                [
                                    require.resolve('babel-preset-react-app/dependencies'),
                                    { helpers: true },
                                ],
                            ],
                            cacheDirectory: true,
                            cacheCompression: false,
                            sourceMaps: false,
                            inputSourceMap: false,
                        }
                    },
                    {
                        test: cssRegex,
                        exclude: cssModuleRegex,
                        use: getStyleLoaders({
                            importLoaders: 1,
                            sourceMap: false,
                            modules: {
                                mode: 'icss',
                            }
                        }),
                        sideEffects: true
                    },
                    {
                        test: cssModuleRegex,
                        use: getStyleLoaders({
                            importLoaders: 1,
                            sourceMap: false,
                            modules: {
                                mode: 'local',
                                getLocalIdent: getCSSModuleLocalIdent
                            }
                        })
                    },
                ]
            }
        ].filter(Boolean)
    },
    plugins: [
        new HtmlWebpackPlugin(
            Object.assign(
                {},
                {
                    inject: true,
                    template: './public/index.html',
                },
                {
                    minify: {
                        removeComments: true,
                        collapseWhitespace: true,
                        removeRedundantAttributes: true,
                        useShortDoctype: true,
                        removeEmptyAttributes: true,
                        removeStyleLinkTypeAttributes: true,
                        keepClosingSlash: true,
                        minifyJS: true,
                        minifyCSS: true,
                        minifyURLs: true,
                    }
                }
            )
        ),
        new InlineChunkHtmlPlugin(HtmlWebpackPlugin, [/runtime-.+[.]js/]),
        new InterpolateHtmlPlugin(HtmlWebpackPlugin, {}),
        new ModuleNotFoundPlugin('./'),
        new MiniCssExtractPlugin({
          filename: bundleCSSfileName,
        }),
        new FileManagerPlugin({
            events: {
                onEnd: [{
                    copy: [
                        {
                            source: path.join(__dirname, bundlesDir, bundleJSfileName),
                            destination: path.join(__dirname, publicJSpath, bundleJSfileName)
                        },
                        {
                            source: path.join(__dirname, bundlesDir, bundleCSSfileName),
                            destination: path.join(__dirname, publicJSpath, bundleCSSfileName)
                        }
                    ]
                }]
            }
        })
    ].filter(Boolean),
    performance: false,
};