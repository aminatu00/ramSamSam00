@extends('layouts.template')
@section('content')


<div class="col-md-6">
    <div class="row">
        <form method="POST" action="{{ route('register.mentor') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <select class="form-control" id="niveau" name="niveau" required>
                    <option value="licence 1">Licence 1</option>
                    <option value="licence 2">Licence 2</option>
                    <option value="licence 3">Licence 3</option>
                    <option value="master 1">Master 1</option>
                    <option value="master 2">Master 2</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expertise">Domaines</label>
                <select class="form-control" id="expertise" name="expertise[]" multiple required>
                    @foreach($domains as $domain => $subExpertises)
                        <option value="{{ $domain }}">{{ ucfirst($domain) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sub_expertises">Sous-expertises</label>
                <div id="sub_expertises-container"></div>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</div>
<script>
    document.getElementById('expertise').addEventListener('change', function() {
        let selectedDomaines = Array.from(this.selectedOptions).map(option => option.value);
        let container = document.getElementById('sub_expertises-container');
        container.innerHTML = '';

        // const domains = @json($domains);
        const domains = <?php echo json_encode($domains); ?>;
        selectedDomaines.forEach(domaine => {
            if (domains[domaine]) {
                let domainDiv = document.createElement('div');
                domainDiv.className = 'form-group';
                domainDiv.innerHTML = `<label>${domaine.charAt(0).toUpperCase() + domaine.slice(1)}</label>`;
                domains[domaine].forEach(subExpertise => {
                    domainDiv.innerHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sub_expertises[]" value="${subExpertise}" id="sub_expertise_${subExpertise}">
                            <label class="form-check-label" for="sub_expertise_${subExpertise}">${subExpertise}</label>
                        </div>`;
                });
                container.appendChild(domainDiv);
            }
        });
    });
</script>
@endsection
