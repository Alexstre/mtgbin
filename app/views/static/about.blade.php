@extends('layouts.default')
@section('title')
About
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4>What's this all about?</h4>
        <p>MTGB.in lets you post disposable lists of Magic: the Gathering cards.
            I'm aware of great sites like <a href="http://tappedout.net/">TappedOut</a> but sometimes you just need to share a quick list
            without having a permanent record of it on your profile. This is where MTGB.in comes in. The idea is inspired by all the
            different 'bin' sites popular in programming communities.</p>
        <h4>What's this bumping thing?</h4>
        <p>By default, a list will expire after 3 days. If you like a certain list or want to have a link
            available for a while longer, clicking 'Bump' will push the deletion date forward by about a day.</p>
        <h4>What are forks?</h4>
        <div class="row">
            <div class="col-sm-3"><img class="img-responsive" src="http://www.ccesonline.com/images/fork260.jpg"></img></div>
            <div class="class-lg-9"><p>Not that. If you like a list but want to modify it, forking allows you to start a new list
                with the current one as a starting point. Once your new list is posted it will be linked with the list it forked
                until one of them expires.</p>
            </div>
        </div>
        <h4>Links, and URL to a list</h4>
        <p>When you create a list you can specify a name for it. This name will be used as the URL and can be shared as needed. If you don't
            provide a name, one will be automatically generated from a pseudorandom list of alphanumeric characters. When specifying your own name,
            spaces will be converted to dashes. Characters other than letters, numbers and dashes will cause an error.</p>

        <h4>Can I post an actual deck list here?</h4>
        <p>Yes! If you post a list of 75 cards the site will assume you're posting a complete deck list in which case the first 60 cards will
            be part of the main deck while the last 15 will be added to the sideboard.</p>

        <h4>What format should I post the list in?</h4>
        <p>I'm working on making the list parser as resilient as possible so that copy-pasting a deck from a lot of different sources
            is fast and easy. For now, each card needs to be on its own line in a format similar to this:
            <ul>
                <li>4 Mutavault, or</li>
                <li>4x Mutavault</li>
            </ul>
            Lines beginning with double-slash (//) will always be ignores. Finally, common words like "Creatures" and "Planeswalkers" will
            be ignored, which is always useful when pasting a list from another source. If you find any bugs or situations where things
            don't get parsed properly please get in touch.</p>
    </div>
</div>
@stop

@section('bottom')

@stop