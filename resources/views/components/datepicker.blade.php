<div class="w-full min-w-40">
    <x-label for="start" :value="__('fields.start.label')" />
    <x-input id="start" type="text" name="start" placeholder="{{ __('fields.start.placeholder') }}"
        value="{{ $start }}" autocomplete="start" x-on:input.debounce.300ms="$form.submit()" autofocus />
</div>

<div class="w-full min-w-40">
    <x-label for="end" :value="__('fields.end.label')" />
    <x-input id="end" type="text" name="end" placeholder="{{ __('fields.end.placeholder') }}"
        value="{{ $end }}" autocomplete="end" x-on:input.debounce.300ms="$form.submit()" />
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#start", {
            dateFormat: "d-m-Y",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                        'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ]
                }
            },
            onChange: function(selectedDates, dateStr) {
                document.querySelector('#start').value = dateStr; // Simpan tanggal di elemen input
            }
        });

        flatpickr("#end", {
            dateFormat: "d-m-Y",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                        'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ]
                }
            },
            onChange: function(selectedDates, dateStr) {
                document.querySelector('#end').value = dateStr; // Simpan tanggal di elemen input
            }
        });
    });
</script>
