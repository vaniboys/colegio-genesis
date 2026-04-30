<div class="p-6 max-w-4xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6"> Política de Privacidade</h1>

    {{-- Dados Recolhidos --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
        <h2 class="text-lg font-bold text-gray-800 mb-3"> Dados Recolhidos</h2>
        <p class="text-gray-600 mb-3">O Colégio Gênesis recolhe apenas os dados necessários para a gestão académica:</p>
        <ul class="list-disc pl-6 space-y-2 text-gray-600">
            <li>Nome completo do aluno</li>
            <li>Data de nascimento</li>
            <li>Número do Bilhete de Identidade (BI)</li>
            <li>Morada e contactos</li>
            <li>Dados do Encarregado de Educação</li>
            <li>Histórico académico (notas, faltas, matrículas)</li>
            <li>Dados financeiros (propinas e pagamentos)</li>
        </ul>
    </div>

    {{-- Finalidade --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
        <h2 class="text-lg font-bold text-gray-800 mb-3"> Finalidade do Tratamento</h2>
        <p class="text-gray-600 mb-3">Os dados são tratados exclusivamente para:</p>
        <ul class="list-disc pl-6 space-y-2 text-gray-600">
            <li>Gestão de matrículas e frequência escolar</li>
            <li>Emissão de boletins e certificados</li>
            <li>Comunicação com encarregados de educação</li>
            <li>Gestão financeira de propinas</li>
            <li>Cumprimento de obrigações legais do Ministério da Educação</li>
        </ul>
    </div>

    {{-- Segurança --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
        <h2 class="text-lg font-bold text-gray-800 mb-3"> Medidas de Segurança</h2>
        <ul class="list-disc pl-6 space-y-2 text-gray-600">
            <li>Dados armazenados em servidores seguros com encriptação</li>
            <li>Acesso restrito por perfis (Admin, Professor, Aluno, Secretaria)</li>
            <li>Palavras-passe encriptadas com algoritmo bcrypt</li>
            <li>Registo de todas as atividades no sistema (auditoria)</li>
            <li>Cópias de segurança automáticas diárias</li>
        </ul>
    </div>

    {{-- Retenção --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
        <h2 class="text-lg font-bold text-gray-800 mb-3"> Período de Retenção</h2>
        <p class="text-gray-600">Os dados são conservados durante o período letivo ativo mais 5 anos após a conclusão ou desistência do aluno, conforme a legislação angolana.</p>
    </div>

    {{-- Direitos --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
        <h2 class="text-lg font-bold text-gray-800 mb-3"> Direitos do Titular dos Dados</h2>
        <ul class="list-disc pl-6 space-y-2 text-gray-600">
            <li><strong>Acesso:</strong> Solicitar cópia dos seus dados pessoais</li>
            <li><strong>Retificação:</strong> Corrigir dados incorretos ou desatualizados</li>
            <li><strong>Eliminação:</strong> Solicitar a remoção dos dados (direito ao esquecimento)</li>
            <li><strong>Portabilidade:</strong> Receber os dados em formato digital</li>
            <li><strong>Oposição:</strong> Opor-se ao tratamento para fins de marketing</li>
        </ul>
    </div>

    {{-- Contacto --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4">
        <h2 class="text-lg font-bold text-gray-800 mb-3"> Encarregado de Proteção de Dados</h2>
        <p class="text-gray-600">Para exercer os seus direitos ou esclarecer dúvidas:</p>
        <div class="mt-3 space-y-1 text-gray-600">
            <p><strong>Email:</strong> privacidade@colegiogenesis.com</p>
            <p><strong>Telefone:</strong> +244 222 123 456</p>
            <p><strong>Morada:</strong> Rua Principal, 123 - Luanda, Angola</p>
        </div>
    </div>

    {{-- Consentimento --}}
    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
        <h2 class="text-lg font-bold text-blue-800 mb-3"> Consentimento</h2>
        <p class="text-blue-700">Ao utilizar o sistema do Colégio Gênesis, o utilizador declara que leu e aceitou esta Política de Privacidade.</p>
    </div>

    <p class="text-center text-gray-400 text-sm mt-6">Última atualização: {{ date('d/m/Y') }}</p>
</div>