<x-app-layout>
    <div class="mb-5">
        <h2 class="mb-2">Selamat Datang, Galih Anggoro Jati</h2>
        <p class="text-gray">Hello Devs! We are on a mission to help developers like you build successful projects for FREE.</p>
    </div>

    <div class="row">
        @for ($i = 0; $i < 6; $i++)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justifu-content-center" style="gap: 1.2rem;">
                            <div style="width: 80px;" class="bg-primary rounded d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 16 16"><path fill="#fff" d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3c0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156c0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616c0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769c0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/></svg>
                            </div>
                            <div class="flex-1">
                                <h5 class="card-title">Pinjaman Kredit</h5>
                                <div class="">
                                    <h2 class="text-end">1.000.000.000</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</x-app-layout>
