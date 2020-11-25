<?php

	$ret = new stdClass();

    $monthspan = Timespan::Monthspan(time())->splitSpan(20);

	echo json_encode($ret);