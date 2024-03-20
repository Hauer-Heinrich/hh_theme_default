import * as esbuild from 'esbuild'
import * as fs from 'fs'
// import _esOptions from './bundle.config.mjs'

const args = process.argv.slice(2)
const buildType = args[0]

// Load custom config if exists (bundle.config.json), otherwise set some defaults
export const _esOptions =
    fs.existsSync("./bundle.config.json") ?
    await JSON.parse(fs.readFileSync('./bundle.config.json', "utf8")) :
    {
        outdir: ".",
        entryPoints: [
            { in: "./src/css/main.css", out: "./dist/css/bundle" },
            { in: "./src/js/main.js", out: "./dist/js/bundle" },
        ],
        bundle: true,
        write: true,
        minify: true,
        sourcemap: true,
        logLevel: 'info',
        external: [ // Ignore public paths (e.g. static images, fonts, ..)
            './public/*', '../public/*',
            './static/*', '../static/*'
        ],
        "supported": {
            "nesting": false
        }
        // loader: { '.jpg': 'file', '.gif': 'file', '.png': 'file' },
        // packages: 'external', // External dependency loading during runtime
        // target: ['node10.4'], // Specify target (node version) if needed
    }

export const _esBuilder = async function(_esOptions) {
    if(_esOptions.length > 0) {
        _esOptions.forEach(async options => {
            await esbuild.build(options)
        });
    } else {
        await esbuild.build(_esOptions)
    }

    console.log('Build seems complete.')
}

export const _esWatcher = async function(_esOptions) {
    if(_esOptions.length > 0) {
        _esOptions.forEach(async options => {
            const ctx = await esbuild.context(options)
            await ctx.watch()
        });
    } else {
        const ctx = await esbuild.context(_esOptions)
        await ctx.watch()
    }

    console.log('Watching...')
}

export default {
    _esOptions,
    _esBuilder,
    _esWatcher
}

if(buildType) {
    switch (buildType) {
        case "options":
            console.log("_esOptions: ")
            console.log(_esOptions)
            break;
        case "build":
            _esBuilder(_esOptions)
            break;
        case "watch":
            _esWatcher(_esOptions)
            break;
        default:
            console.log("Please specify one of the following arguments as string: \"build\", \"watch\" or \"options\"")
            break;
    }
}
