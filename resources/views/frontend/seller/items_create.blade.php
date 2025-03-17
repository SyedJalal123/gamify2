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
                <input type="file" id="imageInput" name="images[]" class="form-control" multiple onchange="event.preventDefault();">
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let selectedFiles = []; // Store selected files
        let featureImageName = null; // Track feature image

        document.getElementById('imageInput').addEventListener('change', function(event) {
            let files = Array.from(event.target.files);
            let previewContainer = document.getElementById('imagePreviewContainer');

            files.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name)) { // Avoid duplicate images
                    selectedFiles.push(file);

                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('image-wrapper');
                        imageWrapper.style.position = 'relative';
                        imageWrapper.style.margin = '10px';
                        imageWrapper.style.display = 'inline-block';
                        imageWrapper.style.border = '2px solid transparent';

                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.dataset.filename = file.name;

                        // Feature Image Tag
                        let featureTag = document.createElement('div');
                        featureTag.innerText = 'Feature';
                        featureTag.classList.add('feature-tag');
                        featureTag.style.position = 'absolute';
                        featureTag.style.top = '5px';
                        featureTag.style.left = '5px';
                        featureTag.style.background = 'gold';
                        featureTag.style.color = 'black';
                        featureTag.style.padding = '2px 5px';
                        featureTag.style.borderRadius = '5px';
                        featureTag.style.display = 'none'; // Hidden by default

                        // Feature Image Button
                        let featureButton = document.createElement('button');
                        featureButton.innerText = 'Set Feature';
                        featureButton.type = 'button';
                        featureButton.style.position = 'absolute';
                        featureButton.style.bottom = '5px';
                        featureButton.style.left = '5px';
                        featureButton.style.background = 'green';
                        featureButton.style.color = 'white';
                        featureButton.style.border = 'none';
                        featureButton.style.cursor = 'pointer';
                        featureButton.addEventListener('click', function() {
                            setFeatureImage(file.name, imageWrapper, featureTag);
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
                            
                            // If the removed image was the feature image, reset feature selection
                            if (featureImageName === file.name) {
                                document.getElementById('featureImageInput').value = ''; // Reset feature image
                                featureImageName = null;

                                // Set the first remaining image as the new feature image
                                if (selectedFiles.length > 0) {
                                    let firstImageWrapper = previewContainer.querySelector('.image-wrapper');
                                    let firstFeatureTag = firstImageWrapper.querySelector('.feature-tag');
                                    let firstImageName = selectedFiles[0].name;
                                    setFeatureImage(firstImageName, firstImageWrapper, firstFeatureTag);
                                }
                            }

                            imageWrapper.remove();
                        });

                        imageWrapper.appendChild(img);
                        imageWrapper.appendChild(featureTag);
                        imageWrapper.appendChild(featureButton);
                        imageWrapper.appendChild(removeButton);
                        previewContainer.appendChild(imageWrapper);

                        // Automatically set the first image as the feature image
                        if (selectedFiles.length === 1) {
                            setFeatureImage(file.name, imageWrapper, featureTag);
                        }
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Reset the file input to allow re-selection of the same file
            event.target.value = '';
        });

        function setFeatureImage(imageName, imageWrapper, featureTag) {
            // Remove highlight from all images
            document.querySelectorAll('.image-wrapper').forEach(el => {
                el.style.border = '2px solid transparent';

                // Hide previous feature tag
                let prevFeatureTag = el.querySelector('.feature-tag');
                if (prevFeatureTag) prevFeatureTag.style.display = 'none';
            });

            // Highlight selected feature image
            imageWrapper.style.border = '2px solid gold';
            featureTag.style.display = 'block';

            // Store feature image filename
            document.getElementById('featureImageInput').value = imageName;
            featureImageName = imageName;
        }
    });


</script>
    
    
@endsection