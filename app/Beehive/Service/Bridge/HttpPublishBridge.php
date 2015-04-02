<?php

namespace Beehive\Service\Bridge;

class HttpPublishBridge implements Bridge
{
    public function publish($topic, $data)
    {
        $body = [
            'topic' => $topic,
            'payload' => $data,
        ];

        try {
            $request = \Httpful\Request::post('http://localhost:9999/mqtt/publish')
                ->sendsJson()
                ->body(json_encode($body))
                ->send();
        }
        catch(\Exception $e) {
        }
    }
}
