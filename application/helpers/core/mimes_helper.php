<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| MIME TYPES
| -------------------------------------------------------------------
| This file contains an array of mime types.  It is used by the
| Upload class to help identify allowed file types.
|
*/
function image_mimetypes() {
	return array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 
							 'image/x-icon', 'image/svg+xml');
}

function mimetypes() {
	$mimetypes = array('application/postscript', 'audio/x-aiff', 'audio/x-aiff', 'audio/x-aiff',
										 'text/plain', 'application/atom+xml', 'application/atom+xml', 'audio/basic',
										 'video/x-msvideo', 'application/x-bcpio', 'application/octet-stream',
										 'application/x-netcdf','application/octet-stream', 'application/x-cpio',
										 'application/mac-compactpro', 'application/x-csh', 'text/css', 'text/csv',
								 		 'application/x-director', 'application/x-director',
								 		 'application/octet-stream', 'application/octet-stream', 'application/octet-stream',
										 'application/msword', 'application/xml-dtd', 'application/x-dvi',
										 'application/x-director','application/postscript', 'text/x-setext',
										 'application/octet-stream', 'application/andrew-inset', 'application/srgs',
										 'application/srgs+xml', 'application/x-gtar', 'application/x-hdf',
										 'application/mac-binhex40', 'text/html', 'text/html', 'x-conference/x-cooltalk',
										 'text/calendar', 'text/calendar', 'model/iges', 'model/iges', 'application/x-javascript',
										 'application/json', 'audio/midi', 'application/x-latex', 'application/octet-stream',
										 'application/octet-stream', 'audio/x-mpegurl', 'application/x-troff-man', 'application/mathml+xml',
										 'application/x-troff-me', 'model/mesh', 'audio/midi', 'audio/midi',
										 'application/vnd.mif', 'video/quicktime', 'video/x-sgi-movie', 'audio/mpeg',
										 'audio/mpeg','video/mpeg', 'video/mpeg', 'video/mpeg', 'audio/mpeg', 'application/x-troff-ms',
										 'model/mesh', 'video/vnd.mpegurl', 'application/x-netcdf', 'application/oda',
										 'application/ogg', 'chemical/x-pdb', 'application/pdf', 'application/x-chess-pgn',
										 'application/vnd.ms-powerpoint', 'application/postscript', 'video/quicktime',
										 'audio/x-pn-realaudio', 'audio/x-pn-realaudio', 'application/rdf+xml',
										 'application/vnd.rn-realmedia', 'application/x-troff', 'application/rss+xml',
										 'text/rtf', 'text/richtext', 'text/sgml', 'text/sgml', 'application/x-sh',
										 'application/x-shar', 'model/mesh', 'application/x-stuffit', 'application/x-koan',
										 'application/x-koan', 'application/x-koan', 'application/x-koan', 'application/smil',
										 'application/smil', 'audio/basic', 'application/octet-stream', 'application/x-futuresplash',
										 'application/x-wais-source', 'application/x-sv4cpio', 'application/x-sv4crc',
										 'application/x-shockwave-flash', 'application/x-troff', 'application/x-tar',
										 'application/x-tcl', 'application/x-tex', 'application/x-texinfo',
										 'application/x-texinfo', 'application/x-troff', 'text/tab-separated-values', 'text/plain',
										 'application/x-ustar', 'application/x-cdlink', 'model/vrml',
										 'application/voicexml+xml', 'audio/x-wav', 'application/vnd.wap.wbxml', 'text/vnd.wap.wml',
										 'application/vnd.wap.wmlc', 'text/vnd.wap.wmlscript', 'application/vnd.wap.wmlscriptc',
										 'model/vrml', 'application/xhtml+xml', 'application/xhtml+xml', 'application/vnd.ms-excel',
										 'application/xml', 'application/xml', 'application/xslt+xml',
										 'application/vnd.mozilla.xul+xml', 'chemical/x-xyz', 'application/zip', 
										 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

	return array_merge(image_mimetypes(), $mimetypes);

}





