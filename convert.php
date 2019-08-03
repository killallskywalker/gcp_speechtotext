<?php 
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=service-account.json');



use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

/**
 * Transcribe an audio file using Google Cloud Speech API
 * Example:
 * ```
 * transcribe_async_gcs('your-bucket-name', 'audiofile.wav');
 * ```.
 *
 * @param string $bucketName The Cloud Storage bucket name.
 * @param string $objectName The Cloud Storage object name.
 * @param string $languageCode The Cloud Storage
 *     be recognized. Accepts BCP-47 (e.g., `"en-US"`, `"es-ES"`).
 * @param array $options configuration options.
 *
 * @return string the text transcription
 */
function transcribe_async_gcs($audioFile,$fileName)
{
    // change these variables
    $encoding = AudioEncoding::FLAC;
    $sampleRateHertz = 16000;
    $languageCode = 'en-US';

    // set string as audio content
    $audio = (new RecognitionAudio())
        ->setUri($audioFile);

    // set config
    $config = (new RecognitionConfig())
        ->setEncoding($encoding)
        ->setSampleRateHertz($sampleRateHertz)
        ->setLanguageCode($languageCode);

    // create the speech client
    $client = new SpeechClient();

    // create the asyncronous recognize operation
    $operation = $client->longRunningRecognize($config, $audio);
    $operation->pollUntilComplete();

    if ($operation->operationSucceeded()) {
        $response = $operation->getResult();

        // each result is for a consecutive portion of the audio. iterate
        // through them to get the transcripts for the entire audio file.
        foreach ($response->getResults() as $result) {
            $alternatives = $result->getAlternatives();
            $mostLikely = $alternatives[0];
            $transcript = $mostLikely->getTranscript();
            $confidence = $mostLikely->getConfidence();
            // printf('%s' . PHP_EOL, $transcript);
            $handle = fopen('text/'.$fileName, 'a') or die('Cannot open file:  '.'text/'.$fileName);
            $data = $transcript.PHP_EOL;
            fwrite($handle, $data);
        }
    } else {
        print_r($operation->getError());
    }

    $client->close();

    return $fileName;
}

?>