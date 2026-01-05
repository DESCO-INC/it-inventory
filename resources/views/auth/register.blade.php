<x-layout >
    <x-slot:heading>
        Sign Up
    </x-slot>
    
    <div class="space-y-4 mb-6">
        <div class="flex justify-center py-10">
          <div class="relative flex flex-col my-6 bg-white shadow-xl border border-slate-200 rounded-lg w-96">
            <div class="p-4">
              <h6 class="mb-5 text-slate-800 text-xl font-semibold">
                Create an Account
              </h6>
              <form method="POST" action="{{ url('/register') }}">
              @csrf
              
              <div class="mb-2">
                  <x-form.label>Name</x-form.label>
                  <div class="mt-2">
                      <x-form.input id="name" name="name" placeholder="Jane Smith" required />
                      <x-form.error name='name'/>
                  </div>
              </div>

              <div class="mb-2">
                  <x-form.label>Email</x-form.label>
                  <div class="mt-2">
                      <x-form.input id="email" name="email" placeholder="JaneSmith@gmail.com" required />
                      <x-form.error name='email'/>
                  </div>
              </div>

              <div class="mb-2">
                  <x-form.label>Password</x-form.label>
                  <div class="mt-2">
                      <x-form.input type="password" id="password" name="password" required/>
                      <x-form.error name='password'/>
                  </div>
              </div>

              <div class="mb-2">
                  <x-form.label>Confirm Password</x-form.label>
                  <div class="mt-2">
                      <x-form.input type="password" id="password_confirmation" name="password_confirmation" required/>
                      <x-form.error name='password_confirmation'/>
                  </div>
              </div>
            </div>
            <div class="px-4 pb-4 pt-0 mt-2">
              <button
                class="w-full rounded-md bg-green-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                type="submit"
              >
                Sign up
              </button>
              </form>
            </div>
          </div>
        </div>

</div>

    </div>
</x-layout>