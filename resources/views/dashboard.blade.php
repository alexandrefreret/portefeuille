<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-8 text-right">
                <a href="{{ route('trades') }}" class="btn btn-primary">{{ __('Liste des trades') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>