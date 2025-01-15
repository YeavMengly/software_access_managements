<form action="{{ route('mandates.update', $mandate->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="report_key">Report:</label>
    <select name="report_key" id="report_key" required>
        @foreach($reports as $report)
            <option value="{{ $report->id }}" {{ $mandate->report_key == $report->id ? 'selected' : '' }}>
                {{ $report->name }}
            </option>
        @endforeach
    </select>

    <label for="mission_type">Mission Type:</label>
    <select name="mission_type" id="mission_type" required>
        @foreach($missionTypes as $missionType)
            <option value="{{ $missionType->id }}" {{ $mandate->mission_type == $missionType->id ? 'selected' : '' }}>
                {{ $missionType->name }}
            </option>
        @endforeach
    </select>

    <label for="value_mandate">Mandate Value:</label>
    <input type="number" name="value_mandate" id="value_mandate" value="{{ old('value_mandate', $mandate->value_mandate) }}" required>

    <label for="attachments">Attachments:</label>
    <input type="file" name="attachments[]" id="attachments" multiple>

    <button type="submit">Update Mandate</button>
</form>
