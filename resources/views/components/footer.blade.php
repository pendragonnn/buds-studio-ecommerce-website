<!-- resources/views/components/footer.blade.php -->
<footer class="bg-[#333] border-t border-pink-100">
  <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <!-- Brand / Logo -->
      <div>
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
          <x-application-logo class="h-10 w-auto text-pink-500" />
          <span class="text-xl font-bold text-pink-200 italic">Buds Studio</span>
        </a>
        <p class="mt-4 text-gray-200 text-sm leading-relaxed">
          Express yourself with our unique press-on nails and phone straps 🌸
        </p>
      </div>

      <!-- Quick Links -->
      <div class="md:mx-auto">
        <h3 class="text-lg font-semibold text-pink-200 mb-4">Quick Links</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#hero" class="text-gray-400 hover:text-pink-600 transition">Home</a></li>
          <li><a href="#products" class="text-gray-400 hover:text-pink-600 transition">Products</a></li>
          <li><a href="#custom-order" class="text-gray-400 hover:text-pink-600 transition">Custom Order</a></li>
          <li><a href="#contact" class="text-gray-400 hover:text-pink-600 transition">Contact</a></li>
        </ul>
      </div>

      <!-- Contact & Social -->
      <div>
        <h3 class="text-lg font-semibold text-pink-200 mb-4">Get in Touch</h3>
        <p class="text-sm text-gray-400">📧 buds.studio@gmail.com</p>
        <p class="text-sm text-gray-400">📱 +62 818-0974-0724</p>
        <div class="flex space-x-4 mt-4">
          <a href="#" class="text-pink-500 hover:text-pink-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M7.75 2C4.68 2 2 4.68 2 7.75v8.5C2 19.32 4.68 22 7.75 22h8.5C19.32 22 22 19.32 22 16.25v-8.5C22 4.68 19.32 2 16.25 2h-8.5zM12 7a5 5 0 100 10 5 5 0 000-10zm6.25-.75a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z" />
            </svg>
          </a>
          <a href="#" class="text-pink-500 hover:text-pink-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M21.54 5.2a8.75 8.75 0 01-2.52.69 4.4 4.4 0 001.93-2.42 8.77 8.77 0 01-2.77 1.06A4.38 4.38 0 0016 3c-2.44 0-4.42 1.98-4.42 4.42 0 .35.04.7.11 1.04A12.46 12.46 0 013 4.6a4.42 4.42 0 001.36 5.9 4.34 4.34 0 01-2-.55v.06c0 2.14 1.52 3.92 3.54 4.32a4.4 4.4 0 01-2 .08 4.42 4.42 0 004.12 3.06A8.8 8.8 0 013 19.54a12.4 12.4 0 006.73 1.97c8.08 0 12.5-6.7 12.5-12.5 0-.19 0-.38-.01-.57a8.95 8.95 0 002.2-2.28z" />
            </svg>
          </a>
          <a href="#" class="text-pink-500 hover:text-pink-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 2.04c-5.52 0-9.96 4.44-9.96 9.96 0 4.41 2.87 8.15 6.84 9.49.5.09.68-.22.68-.49v-1.72c-2.78.61-3.37-1.34-3.37-1.34-.45-1.15-1.11-1.46-1.11-1.46-.91-.63.07-.62.07-.62 1 .07 1.53 1.03 1.53 1.03.89 1.52 2.34 1.08 2.91.83.09-.65.35-1.08.64-1.33-2.22-.25-4.55-1.11-4.55-4.92 0-1.09.39-1.99 1.03-2.69-.1-.25-.45-1.27.1-2.64 0 0 .84-.27 2.75 1.02a9.53 9.53 0 015 0c1.91-1.29 2.75-1.02 2.75-1.02.55 1.37.2 2.39.1 2.64.64.7 1.03 1.6 1.03 2.69 0 3.82-2.34 4.67-4.56 4.92.36.31.68.92.68 1.86v2.75c0 .27.18.59.69.49a9.96 9.96 0 006.83-9.49c0-5.52-4.44-9.96-9.96-9.96z" />
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Bottom Note -->
    <div class="mt-12 border-t border-pink-100 pt-6 text-center text-sm text-gray-500">
      © {{ date('Y') }} Buds Studio. All rights reserved.
    </div>
  </div>
</footer>