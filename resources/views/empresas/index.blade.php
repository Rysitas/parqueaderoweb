                  <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if($empresa)           
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><b>Nombre:</b></td>
                                        <td>{{ $empresa->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>NIT:</b></td>
                                        <td>{{ $empresa->nit }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Ciudad:</b></td>
                                        <td>{{ $empresa->ciudad }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Dirección:</b></td>
                                        <td>{{ $empresa->direccion }}</td>                                      
                                    </tr>
                                    <tr>
                                        <td><b>Gerente:</b></td>
                                        <td>{{ $empresa->gerente }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Horario de Atención:</b></td>
                                        <td>{{ $empresa->horario_atencion}}</td>                                  
                                    </tr>
                                    <tr>
                                        <td><b>Descripción:</b></td>
                                        <td>{{ $empresa->descripcion }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>IVA:</b></td>
                                        <td>{{ $empresa->iva == 'Si' ? 'Empresa responsable del IVA' : 'Empresa no responsable del IVA' }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Logotipo:</b></td>
                                        @if($empresa->logo)
                                        <td><img src="{{ $empresa->logo }}" alt="Logo" style="border-radius: 50%; max-width: 100px;"></td>
                                        @else
                                        <td><img src="{{ secure_asset('img/logo.png') }}" alt="Logo" style="border-radius: 50%; max-width: 100px;"></td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="card">
                                @if (Auth::check() && Auth::user()->tipo == 1)
                                    <a href="{{ route('empresas.create') }}" class="inline-flex items-center px-5 py-3 bg-skye-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-600 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Crear empresa') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>