module.exports = {
    entry: "./public/js/collection_of_part/index.js",
    output: {
        path: __dirname + "/public/js/collection_of_part/",
        filename: "bundle.js"
    },
    mode: "development",
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader"
                }
            }
        ]
    }
};