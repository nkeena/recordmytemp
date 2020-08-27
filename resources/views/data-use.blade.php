@extends('layouts.app')

@section('title', 'Use of Data')

@section('content')
<div class="bg-blue-50 leading-8 max-w-md mx-auto space-y-4 text-blue-800">

    <h1 class="text-blue-900 text-4xl font-bold">Use of Data</h1>

    <p>The following is meant to describe how we obtain and use information collected from you, which may be considered personal data when maintained in an identifiable manner.</p>
    
    <h2 class="text-blue-900 text-2xl font-bold">Registration</h2>
    
    <p>We collect your name, email address, and password when you register for an account on Record My Temp. The email address you provide will be used as your login. We also collect your temperature when you record it. When you create a log, your email address may be used to notify you in cases where a temperature is above normal or a recording is missed. We also automatically store and your timezone to provide accurate reporting.</p>
    
    <p>Registering for an account is required for using the site.</p>
    
    <h2 class="text-blue-900 text-2xl font-bold">Cookies</h2>
    
    <p>Cookies are small data files that we store on your computer or device and access each time you visit the site.</p>
    
    <p>Record My Temp uses various types of cookies, including:</p>
    
    <ul class="list-disc list-inside ml-8">
        <li>Session cookies, which disappear when you log out and close your browser; and</li>
        <li>Persistent cookies, which stay on your device until you or your browser deletes them or they expire</li>
    </ul>
    
    <p>We use cookies to recognize you and/or your device(s) for the following:</p>

    <ul class="list-disc list-inside ml-8">
        <li>Login persistence; if you're signed in to your account, cookies help us keep you logged in and personalize your experience.</li>
    </ul>
    
    <h2 class="text-blue-900 text-2xl font-bold">Securing Data</h2>
    
    <p>We only ask for personal information when we truly need it to provide certain functions of this site to you. What data we store, we’ll protect within commercially acceptable means to prevent loss and theft, as well as unauthorized access, disclosure, copying, use or modification.</p>
    
    <h2 class="text-blue-900 text-2xl font-bold">Links</h2>
    
    <p>Record My Temp may link to external sites that are not operated by us. Please be aware that we have no control over the content and practices of these sites, and cannot accept responsibility or liability for their respective privacy policies.</p>

    <h2 class="text-blue-900 text-2xl font-bold">Updates</h2>
    
    <p>We reserve the right to change the information outlined here at any given time. We encourage you to frequently visit this page to ensure you are up to date with the latest changes.</p>

</div>
@endsection
