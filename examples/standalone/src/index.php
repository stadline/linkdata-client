<?php

declare(strict_types=1);

namespace App;

use Doctrine\Common\Annotations\AnnotationRegistry;
use SportTrackingDataSdk\ClientHydra\Utils\ClientGenerator;
use SportTrackingDataSdk\SportTrackingData\Client\SportTrackingDataClient;
use SportTrackingDataSdk\SportTrackingData\Entity\Activity;

// Config
const STD_BASEURL = 'https://linkdata.dev.geonaute.com';
const SECURITY_TOKEN = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJhY2NvdW50LmRldi5nZW9uYXV0ZS5jb20iLCJleHAiOjE2NTc0MTQ1NzYsImlhdCI6MTU1NzQxMDk3NiwibGRpZCI6IjIzZTExNTIzNDU4OGQyYTE2M2U3Iiwic3RhY2siOiJldTEiLCJmaXJzdG5hbWUiOiJDaGFybGVzIiwibGFzdG5hbWUiOiJBTlNTRU5TIiwiZW1haWwiOiJjYW5zc2Vuc0BnbWFpbC5jb20iLCJnZW5kZXIiOiJGZW1hbGUiLCJiaXJ0aGRhdGUiOiIxOTkwLTAxLTAyIiwiY291bnRyeSI6IlROIiwic3ViIjoiMjYwMTA2NTg1NzUiLCJsb2dpbl9kZWNhdGhsb24iOiJjYW5zc2Vuc0BnbWFpbC5jb20iLCJtaWdyYXRlZCI6dHJ1ZX0.SZSXAxVNZbDX1aI-gQuRMmkLtAGnLhUOaaCwD4F0pOqvaUz84mdCHd-OB_t69zxPN6r8tT1fQMkzcsGvc4gscO0h45Euq_JRJTeM9V1FYfP0ippov3nEcEaFzXANt7RL7NrNR-qTVLg4UJdCp6uAs6Dqf__MreXbDnIiPO15pdjpR2vGrvd3cEOSxIyD5qBAKSXRJk_KLkSTiz6G8n4eIpPTHMGhJjxrqshWztRnuM7GOGp4vQkFU5mPYVlhqrY-n576xZO2VBkbI3sF6aYx4mvdeHsLzVw2woInRY09eZHFwHynE13rAKOlTM66IYgKeI3Yn0Id3SZkOP_tnNZBnWjW0YTDlpRqeq5oMpE0AK-yXG4-UQ85e3q9KViq0Tf47LtqFhQKwbfrRM6D0AGUOQGilL2GJ2ETLHcYE9O3TRVSeMnCYvxyTlGd0XVVo3F_fUY9EcnUMiMAsiBJYKZFCis7BrQjpEiqAVvL_lUAzeLrrh5zos6KpnzzMyFsD9dJdobjX8cNLPAtpGiFgTwRCSLZUsa-4Bl3xfwpfYl_h5LqoZqlYqv57Wd-UXXYxDEy11UZJE4QxxIS0mcwstZJGweTkGudM30Y4XjN2equokWCLFzqnR7Z6kweiBvqxbMS6I6XqBe1o62Pt7mHwWZlAYFw-3jQS2U1ROmXZ6G4SEA';

$loader = require __DIR__.'/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$stdClient = ClientGenerator::createClient(
    SportTrackingDataClient::class,
    STD_BASEURL,
    static function () {
        return SECURITY_TOKEN;
    }
);

$collection = $stdClient->getCollection(Activity::class, []);
foreach ($collection as $activity) {
    \printf("Activity ID : %s\n", $activity->getId());
}

\printf("%d activites found\n", \count($collection));
