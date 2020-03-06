#!/bin/sh
echo "Purging..." &&
    rootdir="$(dirname "$0")"/.. &&
    sudo rm -rf "$rootdir"/node_modules "$rootdir"/var "$rootdir"/vendor &&
    echo "Done"
