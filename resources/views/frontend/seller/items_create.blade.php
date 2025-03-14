@extends('frontend.app')

@section('content')
    {{-- <div class="container section section--first text-white text-center pb-5 mb-5">
        <h2>Upload an Item</h2>
        
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <input type="hidden" name="game_id" value="{{ $game->id }}">

            <div>
                <label>Title:</label>
                <input type="text" name="title" required>
            </div>

            <div>
                <label>Description:</label>
                <textarea name="description" required></textarea>
            </div>

            <div>
                <label>Delivery Type:</label>
                <select name="delivery_type" required>
                    <option value="instant">Instant</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div>
                <label>Price ($):</label>
                <input type="number" name="price" step="0.01" required>
            </div>

            <div>
                <label>Upload Images:</label>
                <input type="file" name="images[]" multiple accept="image/*">
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div> --}}

    <div class="container section section--first text-white text-center pb-5 mb-5">
        <h2>Upload New Item</h2>
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
    
            <input type="hidden" name="category_id" value="{{ $categoryId }}">
            <input type="hidden" name="game_id" value="{{ $gameId }}">
    
            <div class="mb-3">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
    
            <div class="mb-3">
                <label>Price:</label>
                <input type="number" name="price" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label>Delivery Type:</label>
                <select name="delivery_type" class="form-control" required>
                    <option value="instant">Instant</option>
                    <option value="manual">Manual</option>
                </select>
            </div>
    
            <div class="mb-3">
                <label>Upload Images:</label>
                <input type="file" id="imageInput" name="images[]" class="form-control" multiple>
            </div>
        
            <!-- Image Preview Section -->
            <div id="imagePreviewContainer" class="d-flex flex-wrap"></div>
        
            <!-- Hidden input for feature image -->
            <input type="hidden" name="feature_image" id="featureImageInput">

    
            <button type="submit" class="btn btn-primary">Upload Item</button>
        </form>
    </div>
@endsection

@section('js')
form is uploading when selecting feature image and highlight feature image
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let selectedFiles = []; // Store selected files
    
        document.getElementById('imageInput').addEventListener('change', function(event) {
            let files = Array.from(event.target.files);
            let previewContainer = document.getElementById('imagePreviewContainer');
    
            files.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name)) { // Avoid duplicates
                    selectedFiles.push(file);
    
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('image-wrapper');
                        imageWrapper.style.position = 'relative';
                        imageWrapper.style.margin = '10px';
                        imageWrapper.style.display = 'inline-block';
    
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.dataset.filename = file.name;
    
                        // Feature Image Button
                        let featureButton = document.createElement('button');
                        featureButton.innerText = 'Feature';
                        featureButton.style.position = 'absolute';
                        featureButton.style.bottom = '5px';
                        featureButton.style.left = '5px';
                        featureButton.style.background = 'green';
                        featureButton.style.color = 'white';
                        featureButton.style.border = 'none';
                        featureButton.style.cursor = 'pointer';
                        featureButton.addEventListener('click', function() {
                            document.getElementById('featureImageInput').value = file.name;
                            alert('Feature image selected: ' + file.name);
                        });
    
                        // Remove Button
                        let removeButton = document.createElement('button');
                        removeButton.innerText = 'X';
                        removeButton.style.position = 'absolute';
                        removeButton.style.top = '5px';
                        removeButton.style.right = '5px';
                        removeButton.style.background = 'red';
                        removeButton.style.color = 'white';
                        removeButton.style.border = 'none';
                        removeButton.style.cursor = 'pointer';
                        removeButton.addEventListener('click', function() {
                            selectedFiles = selectedFiles.filter(f => f.name !== file.name);
                            imageWrapper.remove();
                        });
    
                        imageWrapper.appendChild(img);
                        imageWrapper.appendChild(featureButton);
                        imageWrapper.appendChild(removeButton);
                        previewContainer.appendChild(imageWrapper);
                    };
    
                    reader.readAsDataURL(file);
                }
            });
    
            // Reset the file input to allow re-selection of the same file
            event.target.value = '';
        });
    });
</script>
    
@endsection