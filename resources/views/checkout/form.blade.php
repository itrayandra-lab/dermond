@extends('layouts.app')

@section('title', 'Checkout - Dermond')

@section('content')
    <div class="pt-32 pb-20 px-6 min-h-screen bg-dermond-dark">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <span class="text-blue-500 font-bold italic tracking-widest text-sm uppercase mb-2 block">Checkout</span>
                <h1 class="text-4xl font-black text-white">Detail Pengiriman</h1>
            </div>

            @if (session('error'))
                <div class="mb-6 px-4 py-3 rounded-xl bg-red-900/30 text-red-400 border border-red-500/30">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('checkout.process') }}" class="space-y-6 bg-dermond-card p-6 rounded-2xl border border-white/10">
                        @csrf

                        @if($savedAddresses->isNotEmpty())
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Pilih Alamat Tersimpan</label>
                            <div id="saved-addresses" class="space-y-2 mb-4">
                                @foreach($savedAddresses as $addr)
                                <div class="saved-address-option p-4 border border-white/10 rounded-xl cursor-pointer hover:border-blue-500/50 transition-colors {{ $addr->is_default ? 'border-blue-500/50 bg-blue-900/20' : '' }}"
                                     data-address='@json($addr)'
                                     onclick="selectSavedAddress(this)">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                @if($addr->label)<span class="text-xs font-bold tracking-widest text-gray-500 uppercase">{{ $addr->label }}</span>@endif
                                                @if($addr->is_default)<span class="bg-blue-900/30 text-blue-400 text-xs font-bold px-2 py-0.5 rounded">Utama</span>@endif
                                            </div>
                                            <p class="font-semibold text-white">{{ $addr->recipient_name }} • {{ $addr->phone }}</p>
                                            <p class="text-gray-400 text-sm">{{ $addr->full_address }}</p>
                                        </div>
                                        <div class="address-check hidden text-blue-400 ml-2">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div id="new-address-toggle" class="p-4 border border-dashed border-white/20 rounded-xl cursor-pointer hover:border-blue-500/50 hover:bg-white/5 transition-colors text-center" onclick="toggleNewAddressForm()">
                                    <span class="text-sm font-semibold text-gray-400">+ Gunakan Alamat Baru</span>
                                </div>
                            </div>
                            <a href="{{ route('addresses.index') }}" class="text-xs font-bold tracking-widest text-blue-400 uppercase hover:text-blue-300">Kelola Alamat</a>
                        </div>
                        @endif


                        <div id="new-address-form" class="{{ $savedAddresses->isNotEmpty() ? 'hidden' : '' }} space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Alamat Pengiriman</label>
                            <textarea name="shipping_address" id="shipping_address_input" rows="3" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" {{ $savedAddresses->isEmpty() ? 'required' : '' }}>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Provinsi</label>
                                <select id="province_code" name="province_code" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Pilih provinsi</option>
                                    @foreach($provinces ?? [] as $province)
                                        <option value="{{ $province->code }}" data-name="{{ $province->name }}" @selected(old('province_code') === $province->code)>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="shipping_province" id="shipping_province" value="{{ old('shipping_province') }}">
                                @error('province_code')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kota/Kabupaten</label>
                                <select id="city_code" name="city_code" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required @if(! old('city_code')) disabled @endif>
                                    <option value="">Pilih kota/kabupaten</option>
                                </select>
                                <input type="hidden" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}">
                                <input type="hidden" name="shipping_district" id="shipping_district" value="{{ old('shipping_district') }}">
                                @error('city_code')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kecamatan</label>
                                <select id="district_code" name="district_code" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required @if(! old('district_code')) disabled @endif>
                                    <option value="">Pilih kecamatan</option>
                                </select>
                                @error('district_code')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kelurahan/Desa</label>
                                <select id="village_code" name="village_code" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required @if(! old('village_code')) disabled @endif>
                                    <option value="">Pilih kelurahan/desa</option>
                                </select>
                                <input type="hidden" name="shipping_village" id="shipping_village" value="{{ old('shipping_village') }}">
                                @error('village_code')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kode Pos</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                @error('shipping_postal_code')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                @error('phone')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        @if($savedAddresses->count() < \App\Models\UserAddress::MAX_ADDRESSES_PER_USER)
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="save_new_address" name="save_new_address" value="1" class="w-4 h-4 rounded border-white/20 bg-dermond-dark text-blue-500 focus:ring-blue-500" {{ $savedAddresses->isEmpty() ? 'checked' : '' }}>
                            <label for="save_new_address" class="text-sm text-gray-400">Simpan alamat ini untuk checkout berikutnya</label>
                        </div>
                        @endif
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Catatan</label>
                            <textarea name="notes" rows="3" class="w-full rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Opsional">{{ old('notes') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Kode Voucher</label>
                            <div class="flex gap-2">
                                <input type="text" id="voucher_code_input" placeholder="Masukkan kode voucher" class="flex-1 rounded-xl bg-dermond-dark border border-white/10 px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase">
                                <button type="button" id="apply-voucher-btn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold tracking-widest uppercase transition-all">Pakai</button>
                            </div>
                            <input type="hidden" name="voucher_code" id="voucher_code" value="{{ old('voucher_code') }}">
                            <div id="voucher-result" class="mt-2 hidden">
                                <div id="voucher-success" class="hidden px-4 py-3 rounded-xl bg-green-900/30 text-green-400 border border-green-500/30 flex items-center justify-between">
                                    <div><span id="voucher-name" class="font-semibold"></span><span id="voucher-discount-text" class="text-sm ml-2"></span></div>
                                    <button type="button" id="remove-voucher-btn" class="text-green-400 hover:text-green-300"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                </div>
                                <div id="voucher-error" class="hidden px-4 py-3 rounded-xl bg-red-900/30 text-red-400 border border-red-500/30"></div>
                            </div>
                        </div>


                        <div id="shipping-section" class="hidden">
                            <label class="block text-sm font-semibold text-white mb-2">Pilih Kurir</label>
                            <div id="shipping-loading" class="hidden py-4 text-center text-gray-500">
                                <svg class="animate-spin h-5 w-5 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memuat opsi pengiriman...
                            </div>
                            <div id="shipping-error" class="hidden py-4 text-center text-red-400 text-sm"></div>
                            <div id="shipping-options" class="space-y-2 max-h-64 overflow-y-auto"></div>
                            <input type="hidden" name="shipping_courier" id="shipping_courier" value="{{ old('shipping_courier') }}">
                            <input type="hidden" name="shipping_service" id="shipping_service" value="{{ old('shipping_service') }}">
                            <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="{{ old('shipping_cost', 0) }}">
                            <input type="hidden" name="shipping_etd" id="shipping_etd" value="{{ old('shipping_etd') }}">
                            <input type="hidden" name="rajaongkir_destination_id" id="rajaongkir_destination_id" value="{{ old('rajaongkir_destination_id') }}">
                        </div>

                        <p class="text-xs text-gray-500 mb-4">Dengan melanjutkan, Anda menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-blue-400 hover:underline">Syarat & Ketentuan</a> kami.</p>

                        <button type="submit" id="submit-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Pilih kurir terlebih dahulu
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-dermond-card p-6 rounded-2xl border border-white/10 sticky top-28">
                        <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>
                        <div class="space-y-3 text-sm text-gray-400 mb-4">
                            <div class="flex justify-between"><span>Subtotal</span><span class="text-white">Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span></div>
                            <div class="flex justify-between" id="voucher-discount-row" style="display: none;"><span>Diskon Voucher</span><span id="voucher-discount-display" class="text-green-400">-Rp 0</span></div>
                            <div class="flex justify-between"><span>Pengiriman</span><span id="shipping-cost-display" class="text-gray-500">Pilih kurir</span></div>
                        </div>
                        <div class="flex justify-between items-center text-xl font-bold text-white border-t border-white/10 pt-4">
                            <span>Total</span>
                            <span id="total-display">Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-3" id="delivery-policy-text">Pengiriman dilakukan melalui jasa ekspedisi (JNE/SiCepat/AnterAja/dll). Order diproses 1–2 hari kerja setelah pembayaran diterima.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const provinceSelect = document.getElementById('province_code');
            const citySelect = document.getElementById('city_code');
            const districtSelect = document.getElementById('district_code');
            const villageSelect = document.getElementById('village_code');
            const shippingProvinceInput = document.getElementById('shipping_province');
            const shippingCityInput = document.getElementById('shipping_city');
            const shippingDistrictInput = document.getElementById('shipping_district');
            const shippingVillageInput = document.getElementById('shipping_village');
            const shippingSection = document.getElementById('shipping-section');
            const shippingLoading = document.getElementById('shipping-loading');
            const shippingError = document.getElementById('shipping-error');
            const shippingOptions = document.getElementById('shipping-options');
            const shippingCourierInput = document.getElementById('shipping_courier');
            const shippingServiceInput = document.getElementById('shipping_service');
            const shippingCostInput = document.getElementById('shipping_cost_input');
            const shippingEtdInput = document.getElementById('shipping_etd');
            const rajaongkirDestinationInput = document.getElementById('rajaongkir_destination_id');
            const shippingCostDisplay = document.getElementById('shipping-cost-display');
            const totalDisplay = document.getElementById('total-display');
            const submitBtn = document.getElementById('submit-btn');
            const subtotal = {{ $cart->getSubtotal() }};
            let selectedDestinationId = null;

            const routes = {
                cities: '{{ route('indonesia.cities') }}',
                districts: '{{ route('indonesia.districts') }}',
                villages: '{{ route('indonesia.villages') }}',
                searchDestination: '{{ route('shipping.search-destination') }}',
                calculateCost: '{{ route('shipping.calculate-cost') }}',
                voucherApply: '{{ route('voucher.apply') }}',
                voucherRemove: '{{ route('voucher.remove') }}',
            };

            let usingSavedAddress = {{ $savedAddresses->isNotEmpty() ? 'true' : 'false' }};
            const newAddressForm = document.getElementById('new-address-form');
            const shippingAddressInput = document.getElementById('shipping_address_input');


            window.selectSavedAddress = async (element) => {
                document.querySelectorAll('.saved-address-option').forEach(el => {
                    el.classList.remove('border-blue-500/50', 'bg-blue-900/20');
                    el.classList.add('border-white/10');
                    el.querySelector('.address-check')?.classList.add('hidden');
                });
                element.classList.remove('border-white/10');
                element.classList.add('border-blue-500/50', 'bg-blue-900/20');
                element.querySelector('.address-check')?.classList.remove('hidden');

                const address = JSON.parse(element.dataset.address);
                usingSavedAddress = true;
                if (newAddressForm) newAddressForm.classList.add('hidden');
                if (shippingAddressInput) shippingAddressInput.value = address.address;
                document.querySelector('[name="phone"]').value = address.phone;
                document.querySelector('[name="shipping_postal_code"]').value = address.postal_code;
                if (shippingProvinceInput) shippingProvinceInput.value = address.province_name;
                if (shippingCityInput) shippingCityInput.value = address.city_name;
                if (shippingDistrictInput) shippingDistrictInput.value = address.district_name;
                if (shippingVillageInput) shippingVillageInput.value = address.village_name;
                provinceSelect.value = address.province_code;
                await loadCities(address.province_code, address.city_code, address.district_code, address.village_code);
                if (address.city_name) await loadShippingOptions(address.city_name, address.district_name || '');
            };

            window.toggleNewAddressForm = () => {
                document.querySelectorAll('.saved-address-option').forEach(el => {
                    el.classList.remove('border-blue-500/50', 'bg-blue-900/20');
                    el.classList.add('border-white/10');
                    el.querySelector('.address-check')?.classList.add('hidden');
                });
                usingSavedAddress = false;
                if (newAddressForm) newAddressForm.classList.remove('hidden');
                if (shippingAddressInput) shippingAddressInput.value = '';
                document.querySelector('[name="phone"]').value = '';
                document.querySelector('[name="shipping_postal_code"]').value = '';
                provinceSelect.value = '';
                resetSelect(citySelect, 'Pilih kota/kabupaten');
                resetSelect(districtSelect, 'Pilih kecamatan');
                resetSelect(villageSelect, 'Pilih kelurahan/desa');
                if (shippingProvinceInput) shippingProvinceInput.value = '';
                if (shippingCityInput) shippingCityInput.value = '';
                if (shippingDistrictInput) shippingDistrictInput.value = '';
                if (shippingVillageInput) shippingVillageInput.value = '';
                shippingSection.classList.add('hidden');
                shippingOptions.innerHTML = '';
                shippingCourierInput.value = '';
                shippingServiceInput.value = '';
                shippingCostInput.value = '0';
                shippingEtdInput.value = '';
                rajaongkirDestinationInput.value = '';
                selectedDestinationId = null;
                updateTotal(0);
                submitBtn.disabled = true;
                submitBtn.textContent = 'Pilih kurir terlebih dahulu';
            };

            const voucherCodeInput = document.getElementById('voucher_code_input');
            const voucherCodeHidden = document.getElementById('voucher_code');
            const applyVoucherBtn = document.getElementById('apply-voucher-btn');
            const removeVoucherBtn = document.getElementById('remove-voucher-btn');
            const voucherResult = document.getElementById('voucher-result');
            const voucherSuccess = document.getElementById('voucher-success');
            const voucherError = document.getElementById('voucher-error');
            const voucherName = document.getElementById('voucher-name');
            const voucherDiscountText = document.getElementById('voucher-discount-text');
            const voucherDiscountRow = document.getElementById('voucher-discount-row');
            const voucherDiscountDisplay = document.getElementById('voucher-discount-display');
            let currentVoucherDiscount = 0;
            let currentVoucherType = null;
            let currentVoucherCode = null;

            @php $oldValues = ['province' => old('province_code'), 'city' => old('city_code'), 'district' => old('district_code'), 'village' => old('village_code'), 'shippingDistrict' => old('shipping_district'), 'shippingVillage' => old('shipping_village'), 'shippingProvince' => old('shipping_province'), 'shippingCity' => old('shipping_city')]; @endphp
            const oldValues = @js($oldValues);

            const showError = (message) => { if (!message) return; if (window.showToast) { window.showToast(message, 'error'); return; } alert(message); };
            const resetSelect = (select, placeholder) => { if (!select) return; select.innerHTML = ''; const opt = document.createElement('option'); opt.value = ''; opt.textContent = placeholder; select.appendChild(opt); select.disabled = true; };
            const populateSelect = (select, items, placeholder) => { if (!select) return; resetSelect(select, placeholder); if (!items || items.length === 0) return; select.innerHTML = ''; const opt = document.createElement('option'); opt.value = ''; opt.textContent = placeholder; select.appendChild(opt); items.forEach((item) => { const o = document.createElement('option'); o.value = item.code; o.dataset.name = item.name; o.textContent = item.name; select.appendChild(o); }); select.disabled = false; };
            const setHiddenFromSelect = (select, hiddenInput) => { if (!select || !hiddenInput) return; const selected = select.options[select.selectedIndex]; hiddenInput.value = selected?.dataset.name ?? ''; };


            const loadVillages = async (districtCode, selectedVillage = null) => {
                resetSelect(villageSelect, 'Pilih kelurahan/desa');
                if (shippingVillageInput) shippingVillageInput.value = '';
                if (!districtCode) return;
                if (villageSelect) { villageSelect.innerHTML = '<option value="">Memuat...</option>'; villageSelect.disabled = true; }
                try {
                    const response = await axios.get(routes.villages, { params: { district_code: districtCode } });
                    populateSelect(villageSelect, response.data?.data ?? [], 'Pilih kelurahan/desa');
                    if (selectedVillage) { villageSelect.value = selectedVillage; setHiddenFromSelect(villageSelect, shippingVillageInput); }
                } catch (error) { showError('Gagal memuat kelurahan atau desa.'); }
            };

            const loadDistricts = async (cityCode, selectedDistrict = null, selectedVillage = null) => {
                resetSelect(districtSelect, 'Pilih kecamatan');
                resetSelect(villageSelect, 'Pilih kelurahan/desa');
                if (shippingDistrictInput) shippingDistrictInput.value = '';
                if (shippingVillageInput) shippingVillageInput.value = '';
                if (!cityCode) return;
                if (districtSelect) { districtSelect.innerHTML = '<option value="">Memuat...</option>'; districtSelect.disabled = true; }
                try {
                    const response = await axios.get(routes.districts, { params: { city_code: cityCode } });
                    populateSelect(districtSelect, response.data?.data ?? [], 'Pilih kecamatan');
                    if (selectedDistrict) { districtSelect.value = selectedDistrict; setHiddenFromSelect(districtSelect, shippingDistrictInput); await loadVillages(selectedDistrict, selectedVillage); }
                } catch (error) { showError('Gagal memuat kecamatan.'); }
            };

            const loadCities = async (provinceCode, selectedCity = null, selectedDistrict = null, selectedVillage = null) => {
                resetSelect(citySelect, 'Pilih kota/kabupaten');
                resetSelect(districtSelect, 'Pilih kecamatan');
                resetSelect(villageSelect, 'Pilih kelurahan/desa');
                if (!provinceCode) { if (shippingProvinceInput) shippingProvinceInput.value = ''; if (shippingCityInput) shippingCityInput.value = ''; if (shippingDistrictInput) shippingDistrictInput.value = ''; if (shippingVillageInput) shippingVillageInput.value = ''; return; }
                if (citySelect) { citySelect.innerHTML = '<option value="">Memuat...</option>'; citySelect.disabled = true; }
                try {
                    const response = await axios.get(routes.cities, { params: { province_code: provinceCode } });
                    populateSelect(citySelect, response.data?.data ?? [], 'Pilih kota/kabupaten');
                    if (selectedCity) { citySelect.value = selectedCity; setHiddenFromSelect(citySelect, shippingCityInput); await loadDistricts(selectedCity, selectedDistrict, selectedVillage); }
                } catch (error) { showError('Gagal memuat kota atau kabupaten.'); }
            };

            provinceSelect?.addEventListener('change', () => { setHiddenFromSelect(provinceSelect, shippingProvinceInput); if (shippingCityInput) shippingCityInput.value = ''; loadCities(provinceSelect.value); });
            citySelect?.addEventListener('change', () => { setHiddenFromSelect(citySelect, shippingCityInput); if (shippingDistrictInput) shippingDistrictInput.value = ''; if (shippingVillageInput) shippingVillageInput.value = ''; loadDistricts(citySelect.value); });
            districtSelect?.addEventListener('change', () => { setHiddenFromSelect(districtSelect, shippingDistrictInput); if (shippingVillageInput) shippingVillageInput.value = ''; loadVillages(districtSelect.value); });
            villageSelect?.addEventListener('change', () => { setHiddenFromSelect(villageSelect, shippingVillageInput); });

            const formatCurrency = (amount) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);

            const updateTotal = (shippingCost) => {
                let discount = currentVoucherDiscount;
                let displayShipping = shippingCost;
                if (currentVoucherType === 'free_shipping' && shippingCost > 0) {
                    discount = shippingCost;
                    displayShipping = 0;
                    currentVoucherDiscount = shippingCost;
                    if (voucherDiscountDisplay) voucherDiscountDisplay.textContent = `-${formatCurrency(shippingCost)}`;
                    if (voucherDiscountText) voucherDiscountText.textContent = `(-${formatCurrency(shippingCost)})`;
                }
                const total = Math.max(0, subtotal - discount + shippingCost);
                if (totalDisplay) totalDisplay.textContent = formatCurrency(total);
                if (shippingCostDisplay) {
                    if (currentVoucherType === 'free_shipping' && shippingCost > 0) shippingCostDisplay.textContent = 'Gratis';
                    else shippingCostDisplay.textContent = shippingCost > 0 ? formatCurrency(shippingCost) : 'Pilih kurir';
                }
            };


            const applyVoucher = async () => {
                const code = voucherCodeInput.value.trim();
                if (!code) return;
                applyVoucherBtn.disabled = true;
                applyVoucherBtn.textContent = 'Memproses...';
                try {
                    const shippingCost = parseInt(shippingCostInput.value) || 0;
                    const response = await axios.post(routes.voucherApply, { code: code, subtotal: subtotal, shipping_cost: shippingCost });
                    if (response.data.success) {
                        const data = response.data.data;
                        currentVoucherDiscount = data.discount;
                        currentVoucherType = data.type;
                        currentVoucherCode = data.code;
                        voucherCodeHidden.value = data.code;
                        voucherName.textContent = data.code;
                        if (data.type === 'free_shipping') {
                            voucherDiscountText.textContent = shippingCost > 0 ? `(-${formatCurrency(shippingCost)})` : '(Gratis Ongkir)';
                            voucherDiscountDisplay.textContent = shippingCost > 0 ? `-${formatCurrency(shippingCost)}` : '-Rp 0';
                        } else {
                            voucherDiscountText.textContent = `(-${data.discount_formatted})`;
                            voucherDiscountDisplay.textContent = `-${data.discount_formatted}`;
                        }
                        voucherDiscountRow.style.display = 'flex';
                        voucherSuccess.classList.remove('hidden');
                        voucherError.classList.add('hidden');
                        voucherResult.classList.remove('hidden');
                        voucherCodeInput.disabled = true;
                        updateTotal(shippingCost);
                    }
                } catch (error) {
                    const message = error.response?.data?.message || 'Gagal menerapkan voucher.';
                    voucherError.textContent = message;
                    voucherError.classList.remove('hidden');
                    voucherSuccess.classList.add('hidden');
                    voucherResult.classList.remove('hidden');
                } finally {
                    applyVoucherBtn.disabled = false;
                    applyVoucherBtn.textContent = 'Pakai';
                }
            };

            const removeVoucher = () => {
                currentVoucherDiscount = 0;
                currentVoucherType = null;
                currentVoucherCode = null;
                voucherCodeHidden.value = '';
                voucherCodeInput.value = '';
                voucherCodeInput.disabled = false;
                voucherResult.classList.add('hidden');
                voucherSuccess.classList.add('hidden');
                voucherError.classList.add('hidden');
                voucherDiscountRow.style.display = 'none';
                const shippingCost = parseInt(shippingCostInput.value) || 0;
                updateTotal(shippingCost);
            };

            applyVoucherBtn?.addEventListener('click', applyVoucher);
            removeVoucherBtn?.addEventListener('click', removeVoucher);
            voucherCodeInput?.addEventListener('keypress', (e) => { if (e.key === 'Enter') { e.preventDefault(); applyVoucher(); } });

            const deliveryPolicyText = document.getElementById('delivery-policy-text');

            const selectShipping = (option) => {
                document.querySelectorAll('.shipping-option').forEach(el => {
                    el.classList.remove('border-blue-500/50', 'bg-blue-900/20');
                    el.classList.add('border-white/10');
                });
                option.classList.remove('border-white/10');
                option.classList.add('border-blue-500/50', 'bg-blue-900/20');
                const cost = parseInt(option.dataset.cost) || 0;
                const courierName = option.querySelector('.font-semibold.text-white')?.textContent || option.dataset.courier.toUpperCase();
                shippingCourierInput.value = option.dataset.courier;
                shippingServiceInput.value = option.dataset.service;
                shippingCostInput.value = cost;
                shippingEtdInput.value = option.dataset.etd;
                if (deliveryPolicyText) deliveryPolicyText.textContent = `Pengiriman dilakukan melalui jasa ekspedisi ${courierName}. Order diproses 1–2 hari kerja setelah pembayaran diterima.`;
                updateTotal(cost);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Lanjut ke Pembayaran';
            };

            const renderShippingOptions = (costs) => {
                shippingOptions.innerHTML = '';
                if (!costs || costs.length === 0) {
                    shippingError.textContent = 'Tidak ada opsi pengiriman tersedia untuk lokasi ini.';
                    shippingError.classList.remove('hidden');
                    return;
                }
                costs.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'shipping-option p-3 border border-white/10 rounded-xl cursor-pointer hover:border-blue-500/50 transition-colors';
                    div.dataset.courier = item.courier_code;
                    div.dataset.service = item.service;
                    div.dataset.cost = item.cost;
                    div.dataset.etd = item.etd;
                    div.innerHTML = `<div class="flex justify-between items-center"><div><span class="font-semibold text-white">${item.courier_name}</span><span class="text-gray-500 text-sm ml-1">(${item.service})</span></div><span class="font-semibold text-blue-400">${formatCurrency(item.cost)}</span></div><div class="text-xs text-gray-500 mt-1">${item.description} • Estimasi ${item.etd}</div>`;
                    div.addEventListener('click', () => selectShipping(div));
                    shippingOptions.appendChild(div);
                });
            };


            const loadShippingOptions = async (cityName, districtName = '') => {
                if (!cityName) return;
                shippingSection.classList.remove('hidden');
                shippingLoading.classList.remove('hidden');
                shippingError.classList.add('hidden');
                shippingOptions.innerHTML = '';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Pilih kurir terlebih dahulu';
                shippingCourierInput.value = '';
                shippingServiceInput.value = '';
                shippingCostInput.value = '0';
                shippingEtdInput.value = '';
                updateTotal(0);
                try {
                    const searchKeyword = districtName ? `${districtName} ${cityName}` : cityName;
                    const searchResponse = await axios.get(routes.searchDestination, { params: { keyword: searchKeyword } });
                    if (!searchResponse.data?.success || !searchResponse.data?.data?.length) throw new Error('Lokasi tidak ditemukan di sistem pengiriman.');
                    const destination = searchResponse.data.data[0];
                    selectedDestinationId = destination.id;
                    rajaongkirDestinationInput.value = selectedDestinationId;
                    const costResponse = await axios.post(routes.calculateCost, { destination_id: selectedDestinationId });
                    shippingLoading.classList.add('hidden');
                    if (!costResponse.data?.success) throw new Error(costResponse.data?.message || 'Gagal menghitung ongkir.');
                    renderShippingOptions(costResponse.data.data?.costs || []);
                } catch (error) {
                    shippingLoading.classList.add('hidden');
                    const message = error.response?.data?.message || error.message || 'Gagal memuat opsi pengiriman.';
                    shippingError.textContent = message;
                    shippingError.classList.remove('hidden');
                }
            };

            const searchDestinationAndCalculate = async () => {
                const cityName = shippingCityInput?.value || '';
                const districtName = shippingDistrictInput?.value || '';
                await loadShippingOptions(cityName, districtName);
            };

            districtSelect?.addEventListener('change', () => { setTimeout(searchDestinationAndCalculate, 500); });

            if (provinceSelect && oldValues.province) {
                provinceSelect.value = oldValues.province;
                setHiddenFromSelect(provinceSelect, shippingProvinceInput);
                loadCities(oldValues.province, oldValues.city, oldValues.district, oldValues.village).then(() => {
                    if (oldValues.shippingCity && shippingCityInput) shippingCityInput.value = oldValues.shippingCity;
                    else if (citySelect?.value) setHiddenFromSelect(citySelect, shippingCityInput);
                    if (districtSelect?.value) setHiddenFromSelect(districtSelect, shippingDistrictInput);
                    if (villageSelect?.value) setHiddenFromSelect(villageSelect, shippingVillageInput);
                    else if (oldValues.shippingVillage && shippingVillageInput) shippingVillageInput.value = oldValues.shippingVillage;
                });
            }

            @if($savedAddresses->isNotEmpty())
            const defaultAddressEl = document.querySelector('.saved-address-option');
            if (defaultAddressEl) selectSavedAddress(defaultAddressEl);
            @endif
        });
    </script>
@endsection
