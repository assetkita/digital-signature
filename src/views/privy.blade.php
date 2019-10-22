<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Asset Kita') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Document signing page">
</head>
<body>
<div class="privy-document"></div>
<script src="{{ $webSDKEndpoint }}"></script>
<script>
    Privy.openDoc('{{ $documentToken }}', {
        dev: @json(! App::environment('production')),
        container: '.privy-document',
        privyId: '{{ $userId }}',
        signature: {
            page: @json($signaturePageNumber),
            x: @json($signatureHorizontalCoordinate ?? 130),
            y: @json($signatureVerticalCoordinate ?? 468),
            fixed: false
        }
    })
        .on('after-action', data => {
            console.log('on-after-action', data);
        })
        .on('after-sign', data => {
            console.log('on-after-sign', data);
        })
        .on('after-review', data => {
            console.log('on-after-review', data);
        })
</script>
</body>
</html>
