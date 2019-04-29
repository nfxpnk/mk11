// server.js
// load the things we need
const express = require('express');
const app = express();
const fs = require('fs');
const livereload = require('livereload');
const ejs = require('ejs');
const sass = require('node-sass');

// set the view engine to ejs
app.set('view engine', 'ejs');
app.use(express.static('./static'));

function compileEjsTemplate(template) {
    let templateFn = ejs.compile(fs.readFileSync(template, 'utf8'), { filename: template });

    var files = fs.readdirSync('./roster');
    let roster = [];
    for (var i in files) {

        roster[files[i]] = [];
        //console.log(files[i]);

        let content = fs.readFileSync('./roster/' + files[i], 'utf8');
        content = content.split('\r\n');

        for (let key in content) {
            roster[files[i]][key] = {};
            let line = content[key];

            if (line == '') continue;
            if(line.indexOf('=') == 0) {
                roster[files[i]][key] = '<h2>' + line + '</h2>';
                continue;
            }

            
            let parts = line.split(':');

            parts[1] = parts[1].replace(/u/gimu, '1');
            parts[1] = parts[1].replace(/d/gimu, '2');
            parts[1] = parts[1].replace(/l/gimu, '3');
            parts[1] = parts[1].replace(/r/gimu, '4');

            parts[1] = parts[1].replace(/a/gimu, '5');
            parts[1] = parts[1].replace(/b/gimu, '6');
            parts[1] = parts[1].replace(/x/gimu, '7');
            parts[1] = parts[1].replace(/y/gimu, '8');

            parts[1] = parts[1].replace(/1/gimu, '<div class="key-up"></div>');
            parts[1] = parts[1].replace(/2/gimu, '<div class="key-down"></div>');
            parts[1] = parts[1].replace(/3/gimu, '<div class="key-left"></div>');
            parts[1] = parts[1].replace(/4/gimu, '<div class="key-right"></div>');


            parts[1] = parts[1].replace(/5/gimu, '<div class="key-a"></div>');
            parts[1] = parts[1].replace(/6/gimu, '<div class="key-b"></div>');
            parts[1] = parts[1].replace(/7/gimu, '<div class="key-x"></div>');
            parts[1] = parts[1].replace(/8/gimu, '<div class="key-y"></div>');

            console.log(parts[1]);

            roster[files[i]][key] = '<div class="keys">' + parts[1] + '</div>';
        }
    }
    console.log(roster);

    return templateFn({ roster: roster });
    //return templateFn({ roster: roster['raiden.txt'] });
}

// use res.render to load up an ejs view file
// index page
app.get('/mkx', function(req, res) {
    let output = compileEjsTemplate('./index.html');
    res.send(output);
});

let server = livereload.createServer({
    port: 57778,
    exts: ['ejs', 'html', 'json', 'txt', 'html', 'css']
});

server.watch(['index.html', '.']);

fs.watchFile('./scss/styles.scss', { interval: 500 }, (curr, prev) => {
    sass.render(
        {
            file: './scss/styles.scss',
            outFile: './static/css/styles.css'
        },
        function(error, result) {
            // node-style callback from v3.0.0 onwards
            if (!error) {
                // No errors during the compilation, write this result on the disk
                fs.writeFile('./static/css/styles.css', result.css, function(err) {
                    if (!err) {
                        console.log('file written on disk');
                    }
                });
            }
        }
    );
});

app.listen(5060);
console.log('5060 is the magic port');
