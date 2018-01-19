@extends('allstor::layouts.home')


@section('main_content')


        <div class="err404">
            <h1 class="err404-ttl">404</h1>
            <p class="err404-subttl">
                Error. Page not found.
            </p>
            <form action="#" class="err404-search">
                <input type="text" placeholder="Search...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <div class="err404-menus">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="catalog-list.html">Catalog</a></li>
                    <li><a href="elements.html">Elements</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="blog.html">Blog</a></li>
                </ul>
                <ul>
                    <li><a href="catalog-list.html">Women</a></li>
                    <li><a href="catalog-list.html">Men</a></li>
                    <li><a href="catalog-list.html">Kids</a></li>
                    <li><a href="catalog-list.html">Shoes</a></li>
                    <li><a href="catalog-list.html">Accessories</a></li>
                </ul>
                <ul>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="blog.html">News</a></li>
                    <li><a href="blog.html">Reviews</a></li>
                    <li><a href="blog.html">Contacts</a></li>
                    <li><a href="blog.html">Articles</a></li>
                </ul>
                <ul>
                    <li><a href="contacts.html">About us</a></li>
                    <li><a href="contacts.html">Delivery</a></li>
                    <li><a href="contacts.html">Guarantees</a></li>
                    <li><a href="contacts.html">How to buy</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                </ul>

            </div>
        </div>


@endsection


