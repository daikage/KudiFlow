@extends('layouts.tailwind')

@section('title', 'Point of Sale')
@section('search_placeholder', 'Scan or type barcode/SKU...')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-extrabold">POS</h2>
        <div class="flex items-center gap-2">
          <input id="barcodeInput" type="text" placeholder="Scan barcode or enter SKU" class="px-3 py-2 rounded-lg border border-outline-variant/30 bg-surface-container-low w-64" autofocus>
          <button id="scanBtn" class="px-4 py-2 rounded-lg bg-primary text-on-primary">Add</button>
          <!-- NEW: Mobile-only camera scan button -->
          <button id="openCameraBtn" class="md:hidden px-3 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Scan with Camera</button>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-surface-container">
            <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
              <th class="px-4 py-3">Product</th>
              <th class="px-4 py-3">Price</th>
              <th class="px-4 py-3">Qty</th>
              <th class="px-4 py-3">Total</th>
              <th class="px-4 py-3"></th>
            </tr>
          </thead>
          <tbody id="cartBody">
            @forelse($cart['items'] as $item)
              <tr data-id="{{ $item['id'] }}" class="border-t border-outline-variant/10">
                <td class="px-4 py-3">
                  <div class="font-medium">{{ $item['name'] }}</div>
                  <div class="text-xs text-on-surface-variant">SKU: {{ $item['sku'] }} @if($item['barcode']) | BAR: {{ $item['barcode'] }} @endif</div>
                </td>
                <td class="px-4 py-3">₦{{ number_format($item['price'], 2) }}</td>
                <td class="px-4 py-3">
                  <input type="number" min="1" value="{{ $item['qty'] }}" class="qtyInput w-20 px-2 py-1 rounded border border-outline-variant/30 bg-surface-container-low">
                </td>
                <td class="px-4 py-3">₦{{ number_format($item['price'] * $item['qty'], 2) }}</td>
                <td class="px-4 py-3">
                  <button class="removeBtn px-3 py-1 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Remove</button>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="px-4 py-6 text-center text-on-surface-variant">Cart is empty.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="space-y-4">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-2">Summary</h3>
        <div class="flex items-center justify-between text-sm">
          <span>Subtotal</span>
          <span id="subtotal">₦{{ number_format($cart['subtotal'], 2) }}</span>
        </div>
        <div class="flex items-center justify-between text-sm mt-1">
          <span>Tax</span>
          <span id="tax">₦{{ number_format($cart['tax'], 2) }}</span>
        </div>
        <div class="flex items-center justify-between font-bold text-lg mt-2">
          <span>Total</span>
          <span id="total">₦{{ number_format($cart['total'], 2) }}</span>
        </div>
        <div class="mt-4">
          <select id="paymentMethod" class="w-full px-3 py-2 rounded-lg border border-outline-variant/30 bg-surface-container-low">
            <option value="">Select payment...</option>
            <option value="cash">Cash</option>
            <option value="pos">POS / Card</option>
            <option value="transfer">Transfer</option>
          </select>
        </div>
        <button id="checkoutBtn" class="w-full mt-3 px-4 py-2 rounded-lg bg-primary text-on-primary">Checkout</button>
        <div id="msg" class="text-sm text-on-surface-variant mt-2"></div>
      </div>

      <div class="bg-surface-container rounded-xl p-4 border border-outline-variant/10">
        <p class="text-xs text-on-surface-variant">Tip: Most USB barcode scanners act as a keyboard. Click the input above and scan.</p>
      </div>
    </div>
  </div>

  <!-- NEW: Mobile scanner overlay -->
  <div id="scannerOverlay" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4">
    <div class="relative w-full max-w-sm bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/10">
      <div class="flex items-center justify-between px-4 py-3 border-b border-outline-variant/10">
        <h3 class="font-bold text-sm">Scan Barcode</h3>
        <button id="closeScannerBtn" class="p-2 rounded-lg hover:bg-surface-variant/30">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <div class="p-3">
        <video id="scannerVideo" class="w-full rounded-lg bg-black" autoplay muted playsinline></video>
        <p id="scanHelp" class="text-xs text-on-surface-variant mt-2">
          Align the barcode within the frame. Supports EAN-13, Code 128, and others if your browser supports camera barcode detection.
        </p>
        <p id="scanError" class="hidden text-xs text-error mt-2"></p>
        <div class="mt-3 flex items-center justify-between">
          <button id="switchCamBtn" class="px-3 py-1.5 rounded-lg border border-outline-variant/30 text-sm">Switch Camera</button>
          <button id="stopScanBtn" class="px-3 py-1.5 rounded-lg bg-primary text-on-primary text-sm">Stop</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const csrf = '{{ csrf_token() }}';

    function formatCurrency(n) {
      return '₦' + (n || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function refreshCart(cart) {
      const body = document.getElementById('cartBody');
      body.innerHTML = '';
      const items = cart.items || {};
      const ids = Object.keys(items);
      if (ids.length === 0) {
        body.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-on-surface-variant">Cart is empty.</td></tr>';
      } else {
        ids.forEach((id) => {
          const it = items[id];
          const tr = document.createElement('tr');
          tr.setAttribute('data-id', it.id);
          tr.className = 'border-t border-outline-variant/10';
          tr.innerHTML = `
            <td class="px-4 py-3">
              <div class="font-medium">${it.name}</div>
              <div class="text-xs text-on-surface-variant">SKU: ${it.sku} ${it.barcode ? `| BAR: ${it.barcode}` : ''}</div>
            </td>
            <td class="px-4 py-3">${formatCurrency(parseFloat(it.price))}</td>
            <td class="px-4 py-3">
              <input type="number" min="1" value="${it.qty}" class="qtyInput w-20 px-2 py-1 rounded border border-outline-variant/30 bg-surface-container-low">
            </td>
            <td class="px-4 py-3">${formatCurrency(parseFloat(it.price) * parseInt(it.qty))}</td>
            <td class="px-4 py-3">
              <button class="removeBtn px-3 py-1 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Remove</button>
            </td>
          `;
          body.appendChild(tr);
        });
      }
      document.getElementById('subtotal').textContent = formatCurrency(parseFloat(cart.subtotal || 0));
      document.getElementById('tax').textContent = formatCurrency(parseFloat(cart.tax || 0));
      document.getElementById('total').textContent = formatCurrency(parseFloat(cart.total || 0));
    }

    document.getElementById('scanBtn').addEventListener('click', async () => {
      const code = document.getElementById('barcodeInput').value.trim();
      if (!code) return;
      const res = await fetch('{{ route('ui.pos.scan') }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf},
        body: JSON.stringify({code})
      });
      if (res.ok) {
        const js = await res.json();
        const addRes = await fetch('{{ route('ui.pos.add') }}', {
          method: 'POST',
          headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf},
          body: JSON.stringify({product_id: js.product.id, qty: 1})
        });
        const addJson = await addRes.json();
        if (addJson.ok) {
          refreshCart(addJson.cart);
          document.getElementById('barcodeInput').value = '';
        }
      } else {
        const j = await res.json().catch(()=>({}));
        document.getElementById('msg').textContent = j.message || 'Product not found';
      }
    });

    document.getElementById('barcodeInput').addEventListener('keyup', (e) => {
      if (e.key === 'Enter') {
        document.getElementById('scanBtn').click();
      }
    });

    document.getElementById('cartBody').addEventListener('change', async (e) => {
      if (e.target.classList.contains('qtyInput')) {
        const tr = e.target.closest('tr');
        const productId = parseInt(tr.getAttribute('data-id'));
        const qty = parseInt(e.target.value);
        const res = await fetch('{{ route('ui.pos.update') }}', {
          method: 'POST',
          headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf},
          body: JSON.stringify({product_id: productId, qty})
        });
        const js = await res.json();
        if (js.ok) refreshCart(js.cart);
      }
    });

    document.getElementById('cartBody').addEventListener('click', async (e) => {
      if (e.target.classList.contains('removeBtn')) {
        const tr = e.target.closest('tr');
        const productId = parseInt(tr.getAttribute('data-id'));
        const res = await fetch('{{ route('ui.pos.remove') }}', {
          method: 'POST',
          headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf},
          body: JSON.stringify({product_id: productId})
        });
        const js = await res.json();
        if (js.ok) refreshCart(js.cart);
      }
    });

    document.getElementById('checkoutBtn').addEventListener('click', async () => {
      const payment_method = document.getElementById('paymentMethod').value;
      const res = await fetch('{{ route('ui.pos.checkout') }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf},
        body: JSON.stringify({payment_method})
      });
      const js = await res.json().catch(()=>({}));
      const msg = document.getElementById('msg');
      if (js.ok) {
        msg.textContent = 'Sale completed.';
        setTimeout(()=>window.location.reload(), 500);
      } else {
        msg.textContent = js.message || 'Checkout failed.';
      }
    });

    // NEW: Mobile-only camera barcode scanning
    (function setupMobileScanner() {
      const ua = navigator.userAgent || '';
      const isMobileUA = /Mobi|Android|iPhone|iPad|iPod/i.test(ua);
      const openBtn = document.getElementById('openCameraBtn');
      const overlay = document.getElementById('scannerOverlay');
      const closeBtn = document.getElementById('closeScannerBtn');
      const stopBtn = document.getElementById('stopScanBtn');
      const switchBtn = document.getElementById('switchCamBtn');
      const video = document.getElementById('scannerVideo');
      const scanError = document.getElementById('scanError');

      if (!openBtn) return;

      // Hide button on desktop even if viewport is small
      if (!isMobileUA) {
        openBtn.classList.add('hidden');
        return;
      }

      let stream = null;
      let detector = null;
      let scanning = false;
      let facingMode = 'environment';
      let rafId = null;

      async function startScanner() {
        scanError.classList.add('hidden');
        if ('BarcodeDetector' in window) {
          try {
            const formats = await window.BarcodeDetector.getSupportedFormats?.() || ['ean_13','code_128','upc_e','upc_a','code_39','codabar','qr_code'];
            detector = new window.BarcodeDetector({ formats });
          } catch (e) {
            detector = null;
          }
        }
        try {
          stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode }, audio: false });
          video.srcObject = stream;
          await video.play();
          scanning = true;
          loopDetect();
        } catch (err) {
          scanError.textContent = 'Unable to access camera: ' + (err.message || 'Permission denied');
          scanError.classList.remove('hidden');
        }
      }

      async function loopDetect() {
        if (!scanning) return;
        if (detector && video.readyState >= HTMLMediaElement.HAVE_ENOUGH_DATA) {
          try {
            const barcodes = await detector.detect(video);
            if (barcodes && barcodes.length > 0) {
              const code = barcodes[0].rawValue || (barcodes[0].rawValue === '' ? '' : null);
              if (code) {
                await onDetected(code);
                return; // stop after first detection
              }
            }
          } catch (e) {
            // detector might fail sporadically; ignore and continue
          }
        }
        rafId = requestAnimationFrame(loopDetect);
      }

      async function onDetected(code) {
        stopScanner();
        // Fill input and reuse existing flow
        const input = document.getElementById('barcodeInput');
        input.value = code;
        document.getElementById('scanBtn').click();
      }

      function stopScanner() {
        scanning = false;
        if (rafId) cancelAnimationFrame(rafId);
        if (video) {
          video.pause();
          video.srcObject = null;
        }
        if (stream) {
          stream.getTracks().forEach(t => t.stop());
          stream = null;
        }
        overlay.classList.add('hidden');
      }

      function toggleFacing() {
        facingMode = (facingMode === 'environment' ? 'user' : 'environment');
        // Restart stream with new facing
        if (scanning) {
          stopScanner();
        }
        startScanner();
      }

      openBtn.addEventListener('click', startScanner);
      closeBtn.addEventListener('click', stopScanner);
      stopBtn.addEventListener('click', stopScanner);
      switchBtn.addEventListener('click', toggleFacing);

      // Close on overlay background tap
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) stopScanner();
      });

      // Close on ESC (for devices with keyboards)
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !overlay.classList.contains('hidden')) stopScanner();
      });
    })();
  </script>
@endsection
