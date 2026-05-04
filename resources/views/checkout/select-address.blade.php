<x-app-layout>
    <div class="py-16 max-w-4xl mx-auto px-4" x-data="{ showAddressModal: false }">
        <div class="flex justify-between items-end mb-8">
            <h2 class="font-black text-3xl uppercase italic tracking-tighter">Shipping Address</h2>
            <button @click="showAddressModal = true" class="text-[10px] font-black uppercase tracking-widest border-b-2 border-black pb-1 hover:text-gray-500 hover:border-gray-500 transition">
                + Add New Address
            </button>
        </div>
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 text-red-700 text-[10px] font-bold uppercase tracking-widest">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('checkout.review') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                @forelse($addresses as $address)
                    <label class="relative border-2 p-6 cursor-pointer hover:border-black transition group has-[:checked]:border-black">
                        <input type="radio" name="address_id" value="{{ $address->id }}" 
                               class="hidden peer" 
                               {{ $address->is_default ? 'checked' : '' }} required>
                        
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-black">Select Address</span>
                            <div class="w-4 h-4 border-2 border-gray-200 rounded-full flex items-center justify-center peer-checked:border-black">
                                <div class="w-2 h-2 bg-black rounded-full hidden peer-checked:block"></div>
                            </div>
                        </div>

                        <p class="text-sm font-bold uppercase tracking-widest">{{ $address->address_line_1 }}</p>
                        <p class="text-xs text-gray-500 uppercase">{{ $address->city }}, {{ $address->postcode }},{{ $address->country }}</p>
                    </label>
                @empty
                    <div class="col-span-full py-20 border-2 border-dashed border-gray-100 text-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">No addresses saved yet.</p>
                    </div>
                @endforelse
            </div>

            @if($addresses->count() > 0)
                <button type="submit" class="w-full bg-black text-white py-4 text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    CONTINUE TO REVIEW
                </button>
            @endif
        </form>

        <!-- ADD ADDRESS MODAL -->
        <div x-show="showAddressModal" 
             class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition.opacity
             style="display: none;">
            
            <div @click.away="showAddressModal = false" class="bg-white p-8 rounded-xl max-w-md w-full shadow-2xl relative text-left">
                <button @click="showAddressModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-black text-2xl">&times;</button>
                
                <h3 class="font-black text-xl uppercase italic tracking-tighter mb-6">New Shipping Address</h3>

                <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Hidden field to tell the controller to redirect back to checkout, not dashboard -->
                    <input type="hidden" name="redirect" value="checkout">

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Address Line 1</label>
                        <input type="text" name="address_line_1" required class="w-full border-gray-200 mt-1 focus:ring-black focus:border-black text-sm uppercase">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">City</label>
                            <input type="text" name="city" required class="w-full border-gray-200 mt-1 focus:ring-black focus:border-black text-sm uppercase">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Postcode</label>
                            <input type="text" name="postcode" required class="w-full border-gray-200 mt-1 focus:ring-black focus:border-black text-sm uppercase">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-4 mt-4 text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                        SAVE AND SELECT
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>