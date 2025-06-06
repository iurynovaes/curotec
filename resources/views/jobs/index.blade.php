@extends('layouts.app')

@section('content')
<section class="section light-background mt-5">
    <div class="container pt-4">

        <h2 class="mb-4">Jobs</h2>
    
        <!-- Filters -->
        <div id="filters">
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" id="title" class="form-control" placeholder="Search by title">
                </div>
                <div class="col-md-6">
                    <select id="active" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <select id="location_id" class="form-select">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}">
                                {{ $loc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="type" class="form-select">
                        <option value="">All Job Types</option>
                        @foreach($jobTypes as $type)
                            <option value="{{ $type->value }}">
                                {{ ucfirst($type->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="experience_level" class="form-select">
                        <option value="">All Experience Levels</option>
                        @foreach($experienceLevels as $level)
                            <option value="{{ $level->value }}">
                                {{ ucfirst($level->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <button id="filter-btn" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </div>
        
        <!-- Jobs list -->
        <div id="jobs-container" class="row"></div>
    
        <!-- Pagination -->
        <nav id="pagination" class="mt-4"></nav>
    </div>
</section>
@endsection

@push('css')
<style>
    .job-card h5 {
        font-weight: bold;
    }
    .tags {
        display: flex;
        gap: 5px;
        align-items: center;
    }
</style>
@endpush

@push('scripts')
<script>
    let currentPage = 1;

    function fetchJobs(page = 1) {
        const category = document.getElementById('category_id').value;
        const location = document.getElementById('location_id').value;
        const type = document.getElementById('type').value;
        const experienceLevel = document.getElementById('experience_level').value;
        const active = document.getElementById('active').value;
        const title = document.getElementById('title').value;

        let url = `/api/jobs?page=${page}`;
        if (category) url += `&category_id=${category}`;
        if (location) url += `&location_id=${location}`;
        if (type) url += `&type=${type}`;
        if (title) url += `&title=${title}`;
        if (experienceLevel) url += `&experience_level=${experienceLevel}`;
        if (active != '') url += `&active=${parseInt(active)}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                renderJobs(data.data);
                renderPagination(data.meta);
            });
    }

    function renderJobs(jobs) {
        const container = document.getElementById('jobs-container');
        container.innerHTML = '';

        
        jobs.forEach(job => {

            let tags = [
                String(job.category).toUpperCase(), 
                String(job.type).toUpperCase(), 
                String(job.experience_level).toUpperCase(), 
                job.remote ? 'REMOTE' : 'ON SITE'
            ];

            container.innerHTML += `
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body job-card">
                            <h5>${job.title}</h5>
                            <p>${job.description}</p>
                            <small><b>Location:</b> ${job.location || '-'}</small><br><br>
                            <div class="tags">
                                ${tags.map(tag => `<small class="badge text-bg-primary">${tag}</small>`).join('')}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        if (!jobs.length) {
            container.innerHTML += `
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body job-card text-center">
                            <h5>Ops!</h5>
                            <p>We haven't found any job that matches with your current search. Try removing one filter.</p>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    function renderPagination(meta) {
        const pagContainer = document.getElementById('pagination');
        pagContainer.innerHTML = '';

        let html = '<ul class="pagination justify-content-center">';

        for (let page = 1; page <= meta.last_page; page++) {
            html += `
                <li class="page-item ${meta.current_page === page ? 'active' : ''}">
                    <a href="#" class="page-link" data-page="${page}">${page}</a>
                </li>
            `;
        }

        html += '</ul>';
        pagContainer.innerHTML = html;

        document.querySelectorAll('#pagination a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = parseInt(e.target.dataset.page);
                fetchJobs(currentPage);
            });
        });
    }

    document.getElementById('filter-btn').addEventListener('click', () => {
        currentPage = 1;
        fetchJobs(currentPage);
    });

    document.addEventListener('DOMContentLoaded', () => {
        fetchJobs();
    });
</script>
@endpush
