<div class="space-y-5">

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <input name="name"
           value="{{ old('name', $product->name ?? '') }}"
           placeholder="Product name"
           class="w-full border p-4 rounded-xl"
           required>

    <input name="brand"
           value="{{ old('brand', $product->brand ?? '') }}"
           placeholder="Brand"
           class="w-full border p-4 rounded-xl">

    <textarea name="description"
              placeholder="Description"
              class="w-full border p-4 rounded-xl min-h-32"
              required>{{ old('description', $product->description ?? '') }}</textarea>

    <input name="price"
           type="number"
           step="0.01"
           value="{{ old('price', $product->price ?? '') }}"
           placeholder="Price"
           class="w-full border p-4 rounded-xl"
           required>

    <select name="category" class="w-full border p-4 rounded-xl" required>
        @foreach(['Men', 'Women', 'Accessories'] as $category)
            <option value="{{ $category }}"
                @selected(old('category', $product->category ?? '') === $category)>
                {{ $category }}
            </option>
        @endforeach
    </select>

    <div>
        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Sizes</p>

        <div class="flex flex-wrap gap-3">
            @foreach(['XS', 'S', 'M', 'L', 'XL', '2XL'] as $size)
                <label class="border rounded-lg px-4 py-2 text-xs font-bold">
                    <input type="checkbox"
                           name="sizes[]"
                           value="{{ $size }}"
                           @checked(in_array($size, old('sizes', $product->sizes ?? [])))>
                    {{ $size }}
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Colours</p>

        <div class="flex flex-wrap gap-3">
            @foreach(['Black', 'White', 'Navy', 'Grey', 'Beige'] as $color)
                <label class="border rounded-lg px-4 py-2 text-xs font-bold">
                    <input type="checkbox"
                           name="colors[]"
                           value="{{ $color }}"
                           @checked(in_array($color, old('colors', $product->colors ?? [])))>
                    {{ $color }}
                </label>
            @endforeach
        </div>
    </div>

    @if($product && $product->images->count())
        <div>
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">
                Current Images
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                @foreach($product->images as $image)
                    <img src="{{ asset($image->image_path) }}"
                         class="aspect-[3/4] object-cover rounded-xl border">
                @endforeach
            </div>
        </div>
    @endif

    <div>
        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">
            Product Images
        </p>

        <div id="dropZone"
             class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-black">
            <input id="imageInput"
                   type="file"
                   name="images[]"
                   multiple
                   accept="image/*"
                   class="hidden">

            <p class="text-sm font-bold text-gray-700">Drag & drop images here</p>
            <p class="text-xs text-gray-400 mt-1">or click to upload — max 5 images</p>
        </div>

        <div id="previewContainer"
             class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-5"></div>
    </div>

</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');

    let selectedFiles = [];

    dropZone.addEventListener('click', () => imageInput.click());

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('border-black', 'bg-gray-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-black', 'bg-gray-50');
    });

    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-black', 'bg-gray-50');
        addFiles(e.dataTransfer.files);
    });

    imageInput.addEventListener('change', () => {
        addFiles(imageInput.files);
    });

    function addFiles(files) {
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;

            if (selectedFiles.length < 5) {
                selectedFiles.push(file);
            }
        });

        updateInputFiles();
        renderPreviews();
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        imageInput.files = dataTransfer.files;
    }

    function renderPreviews() {
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = e => {
                const div = document.createElement('div');

                div.className = 'relative aspect-[3/4] rounded-xl overflow-hidden bg-gray-100 border';

                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">

                    <button type="button"
                            onclick="removeImage(${index})"
                            class="absolute top-2 right-2 bg-black text-white w-7 h-7 rounded-full text-xs font-bold">
                        ×
                    </button>

                    ${index === 0 ? `
                        <span class="absolute bottom-2 left-2 bg-white px-2 py-1 text-[10px] font-black uppercase">
                            Main
                        </span>
                    ` : ''}
                `;

                previewContainer.appendChild(div);
            };

            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        selectedFiles.splice(index, 1);
        updateInputFiles();
        renderPreviews();
    }
</script>