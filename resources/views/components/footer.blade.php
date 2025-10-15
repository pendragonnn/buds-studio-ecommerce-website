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
        <p class="text-sm text-gray-400">📧 beadsbybuds@gmail.com</p>
        <p class="text-sm text-gray-400">📱 +62 818-0974-0724</p>
        <div class="flex space-x-4 mt-4 items-center justify-start">
          <!-- Instagram -->
          <a href="https://www.instagram.com/buds.studioo/" target="_blank"
            class="transition-transform hover:scale-110">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADK0lEQVR4nO2ZO09UQRiGnwIVIpddy6UVwViIgp2X2ElMVH4BISp/QAWpvbRGQqnBP6CYWMnitVN7EWxUbAUFhArXfMl7komB3TmX3Tkm+yaTnOz55jvz7nzXGWiiiVygF5gA5oEFYAOoZDRMl+ksA+PAoXoQGAReZLho3zEPDGRBYA8wDfyR4h/AA+CCdmc/2cF0mc6LwEN9q6JvTwEtSRUXgZdS9hu4BXTSOHQCt4FNZ3cKSXYiMqXvMq1QOAp80VreAHvjTJ7WxG9AifAoActa033fSYOySzOnY+QHx2Vm23quicikzCfyhjtam4Xoquh1olMjHTvCefmkmdHQDu+7gBWtsaeaogkJWfgLgWUnh5h/7oQZvb9RTVFZQhbL80pkWO/nqilalFCa8sDyzyjwFPik0mNDz7N6ZzI7YUhkjMS5GuZv+nbFmoQ6EhBoAyaBnx6lxypwE2hN8J0O6bC17oroQ0ni/Adn/nPgilPG2OjTb3OO3PuEeapSa51JiJRkCtF2n/SYc8ox4yRJt5I1kTZnJ17FrIXMT15r7ruYZlbJmsik5BeSFHQiE+2Mhf4gRIqOY/uY02444wSAYggio45jp0WUv0ZCEJmV7GXS46p0PQ5BJLJtC7Fp0eeT5OpFZF2y7aRHu3St/+9EOqXrl6d807SqObuVHWkxFtLZR33KaU/Mhwy/RSUxkz9Ncpx1EmIhdImyGCMru7A5Sz4dX72JtKoUr6gAjEPmAPA2L0Xjv2X8kmonH3P6nKcyPkJJ/2o0v6xIdFh5pl3PY45jRztRl8ZqLUWr26pSfNWz1bWrg331anUXMzh8KCiMPlGfsq6xoN9GEvYusQ4fQh8H+WDYp30YD3xA54NHWuO1PB+Z1oL3kSlOVLFLlrzhbpyudEDXCpu+x/cNwiCwpWuFft9JU2Jux5fdhEe3cy58L87EFsfE7Jj/BOHQD3x1Em3sS9GCQ2ZTlyzmbI1Cl3xiy2kXEuefFt3ZbUvZiu4nLqmry6LNjWC6+pQnZpzotC1zSnw97eII8Myj9Mh6lOsVcHrUN8w55UdWizZdHxVarwMH60GgiSaIh7/0wax6IqjhkwAAAABJRU5ErkJggg=="
              alt="Instagram" class="w-7 h-7 object-contain bg-pink-200 rounded p-1" />
          </a>

          <!-- Shopee -->
          <a href="https://shopee.co.id/hddra" target="_blank" class="transition-transform hover:scale-110">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADq0lEQVR4nO2ZW4hOURiGH0PIaSgkZ4ULDSVcMI5zxZ1TDrnggnFWLqYociGSQzmlhhsJM06Jwg2KKArFkAxDJHGDcZoZGqNP79Ruav97rf3v37/JU+vuO7xr77XX+ta34T8ZGQPsAx4CtRpVwF5gNH8BPYFjQFPEOAr0IKUMBGok9AuwU0+/C1Cot7QL+Cqbp8AAUkY34IUE3tKkwhgE3Jbtc6ArKeJMYBKdHey7BCZzgpRQIkHvgf4efvbWPsh3IingqsSUxfBdL9/L5Jk+wE9trx1j+Nsy/KwYvckjy/VEK7KIcVIxlpJHDklEaRYxlinGQfLIdYmYkEWMSYpxLUFdv3eP5kMtzaMm6uE9SIHIJsdxP9NE3snIaqa00lMaTWsoz2Q0mPQyJFCrhXJXRqNIL6Ol8Y7LKT2F9FIijVcyGZ2V0YwsErUCpgJHtFStpK8HXgOXgFVAryziz5BG0xrKYRktjJnESvQbDjtOoy5gtt59WagYpjWUvTJaE3MSrwP3jFUS2kajj57mcaBBdvdi5FkjX9MaymYZbYiR4Ip8zwEdImxtae0GJsfIs0F5TGsoZTLa7hl8hPzeAJ3ILdtdrg2lMiqPWfjtJ/eUu1TL82RU6Rm8zOV1J0SlcpnWUKbJ6KJn8Nl/8KZ3UblMayjjZHTTM3jHwP3bLlu55KbyFGcyKpKRdQV9ma8rq/mfymG9VqUcpjWUfjJ6FTPJAuCTYnxXm8hO+QKS45XiZ+zYFMrImglx6atra33gJH8JbPJsF4VRq5imNZQClQ+NCTzF7sBa4FGL0sQaFUNjxixQjJ8u+j66zNiTYtVG3xS7TiWML4U+K6Z5Ddr3kjR91Ylv3hTWefr38/mGnXaFLJmuzeAHMNLDr0ja7L9LJDdc9ukE2Ko81htzpdjnnHM6ORNgqPI89vCZJh+7oEVS4VLLJEB75bGKwJV5PrVgeQJtUBeGKU+1h0+pT3XuVO+3YCwwEz+OKI/9NPWtsnckdgNrsUSq5XPa4bCza+822X+K+E0XdoPdiAOrZbwHd5YEDtJGbRhzte+3lnib4IrASd+gbdiHPT49BacuRUgr80Dgr22m8QQYjz+H5b/IxXi6S98o4kfnYuC8uioNmtwztYBm6Q3F4axP382pk5cnrkqbaYxkeOAfRNqokTbTGEm7wIcbZx3niomBA7Stq9MWOb0F5iRc0vtSqB3wbZxOTdtAzZWmccHnbTRj+/9K9Wfr8ii+ThrsDDJN/za/AGzkxuSBsIT9AAAAAElFTkSuQmCC"
              alt="Shopee" class="w-7 h-7 object-contain bg-pink-200 rounded p-1" />
          </a>

          <!-- Gmail -->
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=beadsbybuds@gmail.com&su=Inquiry%20from%20Website&body=Hi%20Buds%20Studio,%0A%0AI%20have%20a%20question%20about..."
            target="_blank" class="transition-transform hover:scale-110">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAABEElEQVR4nO3UPS9EQRTG8Z+XiEQoVBL7YSRaKjodHZ3GV1Aolbai0+lU2i1pVHyA/QLeWVk5Jte1V3bYVWzuPzm5c2fOPM/N3DmHmppRZgGX6AwprtEomy7Hcx6tIZi2Qrvo9cEj1mM8g/MBml5gLrRXcV807ia8YDPep3A6ANMzTIfmBp5j/otxN96wG3MTOPqD6TEmQ2sHr4W1b8afsR/zYzj4hekhxkNjr8d6pXE/m6uin49OVImcFI5ru3Rc5Sj/puYPuYmcC/LUIyf3Yib6KYnZyF3BXWHtAWuZpZjIbQJLuMVNjHObTyKn7S3q3W6vMnQSOaXSxlb03UaM25kaic4/R6I27oy8cU3N6PAOZuyuMigmDjQAAAAASUVORK5CYII="
              alt="Gmail" class="w-7 h-7 object-contain bg-pink-200 rounded p-1" />
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