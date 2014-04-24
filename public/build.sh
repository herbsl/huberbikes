#!/bin/bash

yui-compressor css/main.css > ../app/views/main-style.blade.php
cp css/bootstrap.min.css ../app/views/bootstrap-style.blade.php
yui-compressor js/main.js > js/main.min.js

find -name "*.js" | while read file; do gzip -9c < $file > $file.gz; done
find -name "*.css" | while read file; do gzip -9c < $file > $file.gz; done
find -name "*.ttf" | while read file; do gzip -9c < $file > $file.gz; done
find -name "*.woff" | while read file; do gzip -9c < $file > $file.gz; done
