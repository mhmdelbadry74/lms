@if ($product->hasMedia())
<div class="media-library-container">
    <div class="media-library-header">
        <h4>product Media</h4>
        <div class="media-library-actions">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
                <i class="fas fa-plus"></i> Add Media
            </button>
        </div>
    </div>

    <div class="media-library-grid">
        @foreach($product->media as $media)
        <div class="media-library-item" data-media-id="{{ $media->id }}">
            <div class="media-library-item-preview">
                @if($media->type === 'image')
                    <img src="{{ $media->getUrl('thumb') }}" 
                         alt="{{ $media->name }}"
                         data-fullsize="{{ $media->getUrl() }}"
                         class="img-fluid"
                         data-bs-toggle="modal" 
                         data-bs-target="#mediaPreviewModal">
                @elseif($media->type === 'video')
                    <div class="video-thumbnail" data-video="{{ $media->getUrl() }}">
                        <i class="fas fa-play"></i>
                        <video class="img-fluid" muted>
                            <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                        </video>
                    </div>
                @else
                    <div class="file-icon">
                        @switch($media->extension)
                            @case('pdf')
                                <i class="fas fa-file-pdf"></i>
                                @break
                            @case('doc')
                            @case('docx')
                                <i class="fas fa-file-word"></i>
                                @break
                            @case('xls')
                            @case('xlsx')
                                <i class="fas fa-file-excel"></i>
                                @break
                            @default
                                <i class="fas fa-file"></i>
                        @endswitch
                    </div>
                @endif
            </div>
            <div class="media-library-item-info">
                <h6 class="media-name">{{ $media->name }}</h6>
                <div class="media-meta">
                    <span class="file-size">{{ $media->human_readable_size }}</span>
                    <span class="file-type">{{ strtoupper($media->extension) }}</span>
                </div>
                
                <div class="media-actions">
                    <a href="{{ $media->getUrlAttribute() }}" 
                        class="btn btn-sm btn-outline-primary" 
                        >
                         <i class="fa fa-download"></i>
                     </a>
                    <button class="btn btn-sm btn-outline-danger delete-media" 
                            data-media-id="{{ $media->id }}"
                            data-url="">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mediaFiles" class="form-label">Select Files</label>
                        <input class="form-control" type="file" id="mediaFiles" name="media[]" multiple>
                    </div>
                    <div id="filePreview" class="file-preview-grid"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="mediaPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="mediaPreviewImage" src="" class="img-fluid" style="display: none;">
                <video id="mediaPreviewVideo" controls style="display: none; width: 100%;"></video>
            </div>
            <div class="modal-footer">
                <a href="#" id="downloadMedia" class="btn btn-primary" download>
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .media-library-container {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .media-library-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .media-library-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    .media-library-item {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .media-library-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .media-library-item-preview {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        position: relative;
    }
    .media-library-item-preview img,
    .media-library-item-preview video {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
    .video-thumbnail {
        position: relative;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .video-thumbnail i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 40px;
        color: rgba(255,255,255,0.8);
        z-index: 2;
    }
    .file-icon {
        font-size: 48px;
        color: #6c757d;
    }
    .media-library-item-info {
        padding: 12px;
    }
    .media-name {
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
    }
    .media-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #6c757d;
        margin: 8px 0;
    }
    .media-actions {
        display: flex;
        gap: 8px;
    }
    .file-preview-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 15px;
    }
    .file-preview-item {
        border: 1px dashed #ddd;
        padding: 5px;
        border-radius: 4px;
        text-align: center;
    }
    .file-preview-item img {
        max-width: 100%;
        max-height: 60px;
    }
</style>

<script>
    // Media preview modal
    document.getElementById('mediaPreviewModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const modal = this;
        
        if (button.hasAttribute('data-fullsize')) {
            // Image preview
            const imgUrl = button.getAttribute('data-fullsize');
            const img = modal.querySelector('#mediaPreviewImage');
            img.src = imgUrl;
            img.style.display = 'block';
            modal.querySelector('#mediaPreviewVideo').style.display = 'none';
            modal.querySelector('#previewTitle').textContent = button.alt;
            modal.querySelector('#downloadMedia').href = imgUrl;
            modal.querySelector('#downloadMedia').download = button.alt;
        } else if (button.hasAttribute('data-video')) {
            // Video preview
            const videoUrl = button.getAttribute('data-video');
            const video = modal.querySelector('#mediaPreviewVideo');
            video.src = videoUrl;
            video.style.display = 'block';
            modal.querySelector('#mediaPreviewImage').style.display = 'none';
            modal.querySelector('#previewTitle').textContent = button.closest('.media-library-item').querySelector('.media-name').textContent;
            modal.querySelector('#downloadMedia').href = videoUrl;
            modal.querySelector('#downloadMedia').download = button.closest('.media-library-item').querySelector('.media-name').textContent + '.mp4';
        }
    });

    // Clear video when modal closes
    document.getElementById('mediaPreviewModal').addEventListener('hidden.bs.modal', function() {
        const video = this.querySelector('#mediaPreviewVideo');
        video.pause();
        video.currentTime = 0;
    });

    // Delete media
    document.querySelectorAll('.delete-media').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this media?')) {
                fetch(this.getAttribute('data-url'), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.media-library-item').remove();
                    }
                });
            }
        });
    });

    // File upload preview
    document.getElementById('mediaFiles').addEventListener('change', function() {
        const previewContainer = document.getElementById('filePreview');
        previewContainer.innerHTML = '';
        
        if (this.files && this.files.length > 0) {
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                const previewItem = document.createElement('div');
                previewItem.className = 'file-preview-item';
                
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        previewItem.innerHTML = `<img src="${e.target.result}" alt="${file.name}"><div>${file.name}</div>`;
                    } else {
                        let icon = 'fa-file';
                        if (file.type.includes('pdf')) icon = 'fa-file-pdf';
                        else if (file.type.includes('word')) icon = 'fa-file-word';
                        else if (file.type.includes('excel')) icon = 'fa-file-excel';
                        else if (file.type.includes('video')) icon = 'fa-file-video';
                        
                        previewItem.innerHTML = `<i class="fas ${icon} fa-2x"></i><div>${file.name}</div>`;
                    }
                    
                    previewContainer.appendChild(previewItem);
                };
                
                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endif