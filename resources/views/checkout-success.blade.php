<x-app-layout>
    <div class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-4 text-center">
            
            <!-- Minimalist Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-8">
                <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="font-black text-5xl text-gray-900 uppercase italic tracking-tighter mb-6">
                Order Simulated
            </h2>
            
            <div class="space-y-6 text-gray-500 text-sm leading-relaxed max-w-lg mx-auto">
                <p class="font-bold text-black uppercase tracking-widest text-[11px]">
                    Note: This is a Portfolio Demonstration
                </p>
                
                <p>
                    You have reached the end of the checkout flow. In a live production environment, 
                    this page would integrate with a payment processor like <strong>PayPal</strong> or <strong>Stripe</strong>.
                </p>

                <p>
                    For this demo, no transaction has occurred, and no personal data has been stored. 
                    This project was built to demonstrate proficiency in <strong>PHP, Laravel, and Tailwind CSS</strong>.
                </p>
            </div>

            <div class="mt-12 pt-12 border-t border-gray-100 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="px-8 py-4 bg-black text-white text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    Return to Shop
                </a>
                
                <a href="https://github.com/your-username/your-repo" target="_blank" class="px-8 py-4 border border-gray-200 text-black text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition">
                    View Code on GitHub
                </a>
            </div>

        </div>
    </div>
</x-app-layout>