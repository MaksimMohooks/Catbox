<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MS Bin File</title>
        <link rel="stylesheet" type="text/css" href="stepfile.css">
        <link rel="shortcut icon" type="image/png" href="Manager_ico.png"/>
        <script src=".sorttable.js"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@500&display=swap');
			body{
                background-color: blue;
				font-family: 'Source Code Pro', monospace;
            }
            .content{
                background: #ffffff;
                width: 50%;
                padding: 40px;
                margin: 100px auto;
                box-shadow: 60px 12px 2px 1px black;
            }
			h1, h2, h3, h4, h5, h6, p, a, span, tr {
				font-family: 'Source Code Pro', monospace;
			}
        </style>
    </head>
</html>
<body>
<div class="content">
    <div id="container">
	<center><h1>MS-Bin Explorer</h1></center>

	<table class="sortable">
	    <thead>
		<tr>
			<th>Filename</th>
			<th>Type</th>
			<th>Size</th>
			<th>Date Modified</th>
		</tr>
	    </thead>
	    <tbody><?php

	
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}

 	
	if($_SERVER['QUERY_STRING']=="hidden")
	{$hide="";
	 $ahref="./";
	 $atext="Hide";}
	else
	{$hide=".";
	 $ahref="./?hidden";
	 $atext="Show";}

	
	 $myDirectory=opendir(".");

	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	}

	// Closes directory
	closedir($myDirectory);

	// Counts elements in array
	$indexCount=count($dirArray);

	// Sorts files
	sort($dirArray);

	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {

	// Decides if hidden files should be displayed, based on query above.
	    if(substr("$dirArray[$index]", 0, 1)!=$hide) {

	// Resets Variables
		$favicon="";
		$class="file";

	// Gets File Names
		$name=$dirArray[$index];
		$namehref=$dirArray[$index];

	// Gets Date Modified
		$modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
		$timekey=date("YmdHis", filemtime($dirArray[$index]));


	// Separates directories, and performs operations on those directories
		if(is_dir($dirArray[$index]))
		{
				$extn="&lt;Directory&gt;";
				$size="&lt;Directory&gt;";
				$sizekey="0";
				$class="dir";

			// Gets favicon.ico, and displays it, only if it exists.
				if(file_exists("$namehref/favicon.ico"))
					{
						$favicon=" style='background-image:url($namehref/favicon.ico);'";
						$extn="&lt;Website&gt;";
					}

			// Cleans up . and .. directories
				if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
				if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
		}

	// File-only operations
		else{
			// Gets file extension
			$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

			// Prettifies file type
			switch ($extn){
                case "png": $extn="PNG Image"; break;
                case "jpg": $extn="JPEG Image"; break;
                case "svg": $extn="SVG Image"; break;
                case "gif": $extn="GIF Image"; break;
                case "ico": $extn="Windows Icon"; break;
                
                case "txt": $extn="Text File"; break;
                case "log": $extn="Log File"; break;
                case "htm": $extn="HTML File"; break;
                case "php": $extn="PHP Script"; break;
                case "js": $extn="Javascript"; break;
                case "css": $extn="Stylesheet"; break;
                case "pdf": $extn="PDF Document"; break;
                
                case "zip": $extn="ZIP Archive"; break;
                case "bak": $extn="Backup File"; break;
                

				default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Unknown";} break;
			}

			// Gets and cleans up file size
				$size=pretty_filesize($dirArray[$index]);
				$sizekey=filesize($dirArray[$index]);
		}

	// Output
	 echo("
		<tr class='$class'>
			<td><a href='./$namehref'$favicon class='name'>$name</a></td>
			<td><a href='./$namehref'>$extn</a></td>
			<td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
			<td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
		</tr>");
	   }
	}
	?>

	    </tbody>
    </table>
    <center><p>NikitaStepler</p></center>
    <center><p>©Stepler Studios</p></center>

</div>
</body>
</html>





