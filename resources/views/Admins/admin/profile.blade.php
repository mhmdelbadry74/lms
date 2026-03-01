@extends('Admins.layout.master')
<style>
    :root {
        --primary-color: #4285f4;
        --secondary-color: #34a853;
        --text-color: #333;
        --light-gray: #f5f5f5;
        --medium-gray: #e0e0e0;
        --dark-gray: #757575;
        --white: #ffffff;
        --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: var(--light-gray);
        color: var(--text-color);
        line-height: 1.6;
    }

    .profile-container {
        max-width: 900px;
        margin: 2rem auto;
        background: var(--white);
        border-radius: 10px;
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }

    .profile-header {
        text-align: center;
        padding: 2rem;
        border-bottom: 1px solid var(--medium-gray);
        position: relative;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        margin: 0 auto 1.5rem;
        position: relative;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid var(--white);
        box-shadow: var(--box-shadow);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: var(--primary-color);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .avatar-edit-btn:hover {
        background: #3367d6;
        transform: scale(1.05);
    }

    .profile-header h1 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .user-title {
        color: var(--dark-gray);
        margin-bottom: 1.5rem;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-3px);
    }

    .stat-number {
        display: block;
        font-weight: bold;
        font-size: 1.2rem;
        color: var(--primary-color);
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--dark-gray);
    }

    .profile-content {
        padding: 2rem;
    }

    .profile-bio {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--medium-gray);
    }

    .profile-bio h2 {
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .profile-details {
        margin-bottom: 2rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .detail-item i {
        width: 30px;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .profile-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: #3367d6;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
    }

    .btn-secondary:hover {
        background: var(--light-gray);
        transform: translateY(-2px);
    }

    .profile-tabs {
        display: flex;
        border-bottom: 1px solid var(--medium-gray);
        margin-bottom: 1.5rem;
    }

    .tab-btn {
        padding: 0.8rem 1.5rem;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        color: var(--dark-gray);
        position: relative;
        transition: all 0.3s ease;
    }

    .tab-btn:hover {
        color: var(--primary-color);
    }

    .tab-btn.active {
        color: var(--primary-color);
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--primary-color);
    }

    .tab-content {
        display: none;
        padding: 1rem 0;
    }

    .tab-content.active {
        display: block;
    }

    .placeholder-content {
        text-align: center;
        padding: 2rem;
        color: var(--dark-gray);
        background: var(--light-gray);
        border-radius: 5px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: var(--white);
        padding: 2rem;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--dark-gray);
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        color: var(--text-color);
        transform: rotate(90deg);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid var(--medium-gray);
        border-radius: 5px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-stats {
            gap: 1rem;
        }

        .profile-actions {
            flex-direction: column;
        }

        .profile-tabs {
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="{{ asset($admin->personal_img) }}" alt="User Avatar" id="user-avatar">
                  
                </div>
                <h1 id="user-name">{{$admin->name}}</h1>
                <p class="user-title" id="user-title">@foreach ( $admin->getRoleNames() as $role)
                    {{ $role }},
                @endforeach</p>
                {{-- <div class="profile-stats">
                    <div class="stat-item">
                        <span class="stat-number" id="post-count">245</span>
                        <span class="stat-label">Posts</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" id="follower-count">1.2K</span>
                        <span class="stat-label">Followers</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" id="following-count">356</span>
                        <span class="stat-label">Following</span>
                    </div>
                </div> --}}
            </div>

            <div class="profile-content">
                {{-- <div class="profile-bio">
                    <h2>About Me</h2>
                    <p id="user-bio">Front-end developer passionate about creating beautiful, user-friendly interfaces.
                        Love hiking and photography on weekends.</p>
                </div> --}}

                <div class="profile-details">
                    <div class="detail-item">
                        <i class="fas fa-envelope"></i>
                        <span id="user-email">{{$admin->email}}</span>
                    </div>
                    {{-- <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span id="user-location">San Francisco, CA</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-link"></i>
                        <a href="#" id="user-website">portfolio.example.com</a>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="user-join-date">Joined June 2020</span>
                    </div> --}}
                </div>

                <div class="profile-actions">
                    @can("update_admin")
                        <a class="btn btn-primary" 
                        href="{{ route('admin.index.UpdateForm', $admin->id) }}"
                        data-bs-toggle="tooltip" 
                        title="{{ __('Edit') }}">
                        <i class="fa fa-edit"></i>
                         </a>
                    @endcan
                </div>
{{-- 
                <div class="profile-tabs">
                    <button class="tab-btn active" data-tab="posts">Posts</button>
                    <button class="tab-btn" data-tab="saved">Saved</button>
                    <button class="tab-btn" data-tab="activity">Activity</button>
                </div>

                <div class="tab-content active" id="posts-tab">
                    <!-- Posts content would be loaded here -->
                    <div class="placeholder-content">
                        <p>User posts will appear here</p>
                    </div>
                </div>

                <div class="tab-content" id="saved-tab">
                    <div class="placeholder-content">
                        <p>Saved items will appear here</p>
                    </div>
                </div>

                <div class="tab-content" id="activity-tab">
                    <div class="placeholder-content">
                        <p>User activity will appear here</p>
                    </div>
                </div> --}}
            </div>
        </div>
        @include("Admins.admin.parts.logs")
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Delete button click handler
            $('.delete-btn').click(function() {
                const adminId = $(this).data('id');
                const adminName = $(this).data('name');
                const deleteUrl = "{{ route('admin.index.delete', ':id') }}".replace(':id', adminId);

                $('#admin-name').text(adminName);
                $('#delete-form').attr('action', deleteUrl);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons and contents
                tabBtns.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });

        // Modal functionality
        const editProfileBtn = document.getElementById('edit-profile-btn');
        const editProfileModal = document.getElementById('edit-profile-modal');
        const closeBtn = document.querySelector('.close-btn');
        const profileForm = document.getElementById('profile-form');

        // Open modal
        editProfileBtn.addEventListener('click', function() {
            // Populate form with current data
            document.getElementById('edit-name').value = document.getElementById('user-name')
                .textContent;
            document.getElementById('edit-title').value = document.getElementById('user-title')
                .textContent;
            document.getElementById('edit-bio').value = document.getElementById('user-bio').textContent;
            document.getElementById('edit-email').value = document.getElementById('user-email')
                .textContent;
            document.getElementById('edit-location').value = document.getElementById('user-location')
                .textContent;
            document.getElementById('edit-website').value = document.getElementById('user-website')
                .textContent;

            editProfileModal.style.display = 'flex';
        });

        // Close modal
        closeBtn.addEventListener('click', function() {
            editProfileModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === editProfileModal) {
                editProfileModal.style.display = 'none';
            }
        });

        // Form submission
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Update profile with new data
            document.getElementById('user-name').textContent = document.getElementById('edit-name')
                .value;
            document.getElementById('user-title').textContent = document.getElementById('edit-title')
                .value;
            document.getElementById('user-bio').textContent = document.getElementById('edit-bio').value;
            document.getElementById('user-email').textContent = document.getElementById('edit-email')
                .value;
            document.getElementById('user-location').textContent = document.getElementById(
                'edit-location').value;
            document.getElementById('user-website').textContent = document.getElementById(
                'edit-website').value;
            document.getElementById('user-website').setAttribute('href', document.getElementById(
                'edit-website').value);

            // Close modal
            editProfileModal.style.display = 'none';

            // Show success message (you could add a toast notification here)
            alert('Profile updated successfully!');
        });

        // Avatar edit functionality
        const editAvatarBtn = document.getElementById('edit-avatar-btn');

        editAvatarBtn.addEventListener('click', function() {
            // In a real app, this would open a file picker
            const newAvatarUrl = prompt('Enter new avatar URL:', 'https://via.placeholder.com/150');

            if (newAvatarUrl) {
                document.getElementById('user-avatar').src = newAvatarUrl;
            }
        });

        // Share profile functionality
        const shareProfileBtn = document.getElementById('share-profile-btn');

        shareProfileBtn.addEventListener('click', function() {
            // In a real app, this would use the Web Share API or similar
            alert('Share profile link: ' + window.location.href);
        });

        // Simulate loading user data (in a real app, this would be an API call)
        function loadUserData() {
            // This is just for demonstration
            // In a real app, you would fetch this from your backend
            const userData = {
                name: "John Doe",
                title: "Web Developer",
                bio: "Front-end developer passionate about creating beautiful, user-friendly interfaces. Love hiking and photography on weekends.",
                email: "john.doe@example.com",
                location: "San Francisco, CA",
                website: "https://portfolio.example.com",
                joinDate: "Joined June 2020",
                avatar: "https://via.placeholder.com/150",
                stats: {
                    posts: 245,
                    followers: 1200,
                    following: 356
                }
            };

            // Update the DOM with the user data
            document.getElementById('user-name').textContent = userData.name;
            document.getElementById('user-title').textContent = userData.title;
            document.getElementById('user-bio').textContent = userData.bio;
            document.getElementById('user-email').textContent = userData.email;
            document.getElementById('user-location').textContent = userData.location;
            document.getElementById('user-website').textContent = userData.website.replace('https://', '');
            document.getElementById('user-website').setAttribute('href', userData.website);
            document.getElementById('user-join-date').textContent = userData.joinDate;
            document.getElementById('user-avatar').src = userData.avatar;
            document.getElementById('post-count').textContent = userData.stats.posts;
            document.getElementById('follower-count').textContent = userData.stats.followers > 1000 ?
                `${(userData.stats.followers / 1000).toFixed(1)}K` :
                userData.stats.followers;
            document.getElementById('following-count').textContent = userData.stats.following;
        }

        // Load user data when the page loads
        loadUserData();
    });
</script>
