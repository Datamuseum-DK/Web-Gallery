#!/bin/sh

# Downloads the old gallery, and converts it for web release.
# Copyright (c) 2021 Dansk Datahistorisk Forening http://datamuseum.dk 
# Author: Carsten Jensen

gallery=/usr/local/www/apache24/webroot/gallery/gallery
scriptdir=/root/scripts
maxpixels=1024

cd $gallery


for i in $(cat $scriptdir/oldgallery.list)
do
	/usr/bin/fetch "https://datamuseum.dk/bits/$i"
	/usr/bin/unzip -d ./ "$i"
	rm -Rf "$i"
	/usr/bin/fetch "https://datamuseum.dk/wiki/Bits:$i" -o $i.html
	/usr/local/bin/php -f $scriptdir/extract_bits.php $i.html
	rm $i.html
done

for i in $(ls -P)
do
	if [ -d "$i" ]
	then
		cd "$i"
		rm *.txt
		cd data
		for j in *.jpg
		do
			echo `pwd`
			if [ -f "$j" ]
			then 
				width=$(/usr/local/bin/identify -format %w "$j")
				height=$(/usr/local/bin/identify -format %h "$j")
				if [ $width -gt $height ]
				then
					if [ $width -gt $maxpixels ]
					then
						/usr/local/bin/magick convert "$j" -resize $maxpixels -quality 80 "$j"
					fi
				elif [ $height -gt $maxpixels ]
				then
					/usr/local/bin/magick convert "$j" -resize x$maxpixels -quality 80 "$j"
				fi
			fi
		done
		for j in *.gif
		do
			echo `pwd`
			if [ -f "$j" ]
			then 
				width=$(/usr/local/bin/identify -format %w "$j")
				height=$(/usr/local/bin/identify -format %h "$j")
				if [ $width -gt $height ]
				then
					if [ $width -gt $maxpixels ]
					then
						/usr/local/bin/magick convert "$j" -resize $maxpixels -quality 80 "$j.jpg"
					fi
				elif [ $height -gt $maxpixels ]
				then
					/usr/local/bin/magick convert "$j" -resize x$maxpixels -quality 80 "$j.jpg"
				fi
			fi
		done
		cd ../..
	fi
	
done



