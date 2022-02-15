<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mail Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div>
                    <!-- todo make ajax call instead -->
                    <form id="mailForm" method="POST" action="{{ route('mailform.process') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Email To</label>
                            <input type="email" name="to" required="required" />
                        </div>
                        <div class="form-group">
                            <label>Email Subject</label>
                            <input type="text" name="subject" required="required" />
                        </div>
                        <div class="form-group">
                            <label>Email Content</label>
                            <textarea name="content"></textarea>
                        </div>

                        <button type="submit" class="">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
