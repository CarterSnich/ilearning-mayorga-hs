@php
    $file = asset("storage/app/submissions/{$sub->username}/{$sub->activity_id}/{$sub->file}");
    $lastname = "$sub->lastname";
    $firstname = "$sub->firstname";
    $middlename = "$sub->middlename";
    
    $name = "{$lastname}, {$firstname} " . ($m = $middlename ? $m[0] . '.' : '');
    $ext = pathinfo($file, PATHINFO_EXTENSION);
@endphp



<div class="file-modal" id="{{ "{$sub->id}-{$sub->username}-{$sub->activity_id}" }}" style="display: none;">

    <div class="file-dialog">
        <div class="file-wrapper">
            @switch($ext)
                @case('mp4')
                @case('webm')
                    <video src="{{ $file }}" controls></video>
                @break

                @case('jpeg')
                @case('jpg')

                @case('png')
                @case('gif')
                    <img src="{{ $file }}" alt="{{ $file }}">
                @break

                @case('pdf')
                    <iframe src="{{ $file }}"></iframe>
                @break

                @default
                    <pre>Unsupported file. <a href="{{ $file }}" target="_blank">Click here to download.</a></pre>
            @endswitch
        </div>


        <form class="submission-details" action="{{ request()->url() . "/submission/{$sub->id}/" }}" method="POST">
            @csrf
            <div class="row">
                <span>Submitted by: </span>
                <span>{{ $name }}</span>
            </div>
            <div class="row">
                <span>Date submitted: </span>
                <span>{{ Carbon\Carbon::parse($sub->created_at)->format('F j, Y') }}</span>
            </div>
            <div class="score-box">
                <span>Score</span>
                <span>
                    <input type="number" name="score" id="score" value="{{ $sub->score }}" required> / {{ $sub->max_score }}
                </span>
            </div>
            <button type="submit" id="save-score-button">Save</button>
        </form>


    </div>

</div>
