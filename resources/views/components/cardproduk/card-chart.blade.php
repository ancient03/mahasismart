<div class="bg-white rounded-lg shadow-md p-4 flex space-x-4">
                    
                    <div class="flex-shrink-0 w-24 h-24 md:w-32 md:h-32 bg-gray-300 rounded-lg">
                        </div>

                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-sm text-gray-600">Harga</span>
                            <h3 class="font-bold text-lg md:text-xl text-gray-900">Judul Barang</h3>
                            <span class="text-sm text-gray-600">Toko</span>
                        </div>
                    </div>

                    <div class="flex-shrink-0 flex flex-col justify-between items-end">
                        {{-- check box --}}
                        <label class="flex items-center cursor-pointer relative" for="check-2">
                            <input type="checkbox"
                            checked
                            class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                            id="check-2" />
                            <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                                stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                            </svg>
                            </span>
                        </label>
                        
                        <div class="flex items-center space-x-2 mt-4">
                            <button class="text-gray-500 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-l-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <input type="text" value="1" class="w-12 h-8 text-center border-l border-r border-gray-300 focus:outline-none">
                                <button class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-r-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>