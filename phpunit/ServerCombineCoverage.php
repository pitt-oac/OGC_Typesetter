<?php

require dirname(__DIR__) . '/vendor/autoload.php';

if( class_exists('\SebastianBergmann\CodeCoverage\CodeCoverage') ){

	$include_dir	= dirname(__DIR__).'/include';
	$filter			= new \SebastianBergmann\CodeCoverage\Filter();
	$filter->includeDirectory($include_dir);
	$filter->excludeDirectory($include_dir.'/thirdparty');

	// requires xdebug or pcov
	$driver			= (new \SebastianBergmann\CodeCoverage\Driver\Selector)->forLineCoverage($filter);
	$cov_obj		= new \SebastianBergmann\CodeCoverage\CodeCoverage($driver, $filter);


	$cov_dir		= dirname(__DIR__).'/x_coverage';
	$files			= scandir($cov_dir);
	$file_count		= 0;

	foreach($files as $file){

		if( $file === '.' || $file === '..' ){
			continue;
		}

		if( strpos($file,'request-') !== 0 ){
			echo "\n - invalid coverage file: ".$file;
			continue;
		}

		echo "\n - coverage file: ".$file;

		$file	= $cov_dir.'/'.$file;
		$data	= json_decode( file_get_contents($file),true );
		$cov_obj->append(\SebastianBergmann\CodeCoverage\RawCodeCoverageData::fromXdebugWithoutPathCoverage($data), $file);
		$file_count++;
	}

	echo "\n - ".$file_count.' coverage files combined in '.$cov_dir;
	echo "\n";

	$cov_file	= $cov_dir.'/requests.clover';
	$writer		= new \SebastianBergmann\CodeCoverage\Report\Clover;
	$writer->process($cov_obj, $cov_file);
}
