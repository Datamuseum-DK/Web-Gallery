#!/bin/sh

# Downloads the old gallery, and converts it for web release.
# Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
# Author: Carsten Jensen

gallery=/usr/local/www/apache24/webroot/gallery/gallery
scriptdir=/root/scripts
maxpixels=1024

cd $gallery


for i in $(ls)
do
	/usr/local/bin/php -f $scriptdir/update_bits.php $i/metadata.meta "$gallery/$i"
done




