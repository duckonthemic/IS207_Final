@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Về chúng tôi</h1>
    
    <div class="prose prose-lg max-w-none">
        <p class="text-gray-700 mb-4">
            PC Parts E-Store là một nền tảng mua bán linh kiện máy tính trực tuyến hàng đầu, 
            cung cấp các sản phẩm chất lượng cao từ các thương hiệu nổi tiếng trên thế giới.
        </p>
        
        <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Sứ mệnh</h2>
        <p class="text-gray-700 mb-4">
            Chúng tôi cam kết cung cấp cho khách hàng những linh kiện máy tính chất lượng cao 
            với giá cạnh tranh nhất, dịch vụ tận tình và hỗ trợ chuyên nghiệp.
        </p>
        
        <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Tầm nhìn</h2>
        <p class="text-gray-700 mb-4">
            Trở thành nhà cung cấp linh kiện máy tính hàng đầu tại Việt Nam, 
            được khách hàng tin tưởng và lựa chọn.
        </p>
        
        <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Liên hệ</h2>
        <p class="text-gray-700">
            Nếu bạn có bất kỳ câu hỏi nào, vui lòng <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-700">liên hệ với chúng tôi</a>.
        </p>
    </div>
</div>
@endsection
