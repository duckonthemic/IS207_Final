@extends('layouts.app')

@section('content')
<div class="bg-cyber-black min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12 border-b border-cyber-border pb-6">
            <h1 class="text-4xl font-black text-cyber-white mb-2 uppercase tracking-tighter">Blog & News</h1>
            <p class="text-cyber-text-muted font-mono text-sm">// LATEST_UPDATES_FROM_UITECH</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Blog Post 1 -->
            <div class="bg-cyber-black border border-cyber-border group hover:border-cyber-white transition-colors duration-300">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-cyber-text-muted uppercase tracking-wider">Hardware Guide</span>
                        <span class="text-xs font-mono text-cyber-text-muted">02-11-2025</span>
                    </div>
                    <h2 class="text-2xl font-bold text-cyber-white mb-4 uppercase tracking-wide group-hover:text-cyber-text-muted transition-colors">
                        Hướng dẫn chọn CPU cho máy tính
                    </h2>
                    <p class="text-cyber-text mb-6 font-light leading-relaxed line-clamp-3">
                        CPU là bộ xử lý trung tâm của máy tính, lựa chọn đúng CPU sẽ quyết định hiệu năng của máy. Tìm hiểu cách đọc thông số và chọn CPU phù hợp với nhu cầu của bạn.
                    </p>
                    <a href="#" class="inline-flex items-center text-cyber-white font-bold uppercase tracking-widest text-xs hover:text-cyber-text-muted transition-colors">
                        [READ_MORE] <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
            
            <!-- Blog Post 2 -->
            <div class="bg-cyber-black border border-cyber-border group hover:border-cyber-white transition-colors duration-300">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-cyber-text-muted uppercase tracking-wider">Comparison</span>
                        <span class="text-xs font-mono text-cyber-text-muted">31-10-2025</span>
                    </div>
                    <h2 class="text-2xl font-bold text-cyber-white mb-4 uppercase tracking-wide group-hover:text-cyber-text-muted transition-colors">
                        So sánh RAM DDR4 vs DDR5
                    </h2>
                    <p class="text-cyber-text mb-6 font-light leading-relaxed line-clamp-3">
                        DDR5 là thế hệ RAM mới nhất với tốc độ nhanh hơn và tiết kiệm điện năng hơn so với DDR4. Liệu sự nâng cấp này có đáng giá cho game thủ ở thời điểm hiện tại?
                    </p>
                    <a href="#" class="inline-flex items-center text-cyber-white font-bold uppercase tracking-widest text-xs hover:text-cyber-text-muted transition-colors">
                        [READ_MORE] <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
            
            <!-- Blog Post 3 -->
            <div class="bg-cyber-black border border-cyber-border group hover:border-cyber-white transition-colors duration-300">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-cyber-text-muted uppercase tracking-wider">Storage</span>
                        <span class="text-xs font-mono text-cyber-text-muted">30-10-2025</span>
                    </div>
                    <h2 class="text-2xl font-bold text-cyber-white mb-4 uppercase tracking-wide group-hover:text-cyber-text-muted transition-colors">
                        Lựa chọn SSD cho gaming
                    </h2>
                    <p class="text-cyber-text mb-6 font-light leading-relaxed line-clamp-3">
                        SSD NVMe M.2 là lựa chọn tốt nhất cho gaming, cho phép tải trò chơi nhanh chóng. Khám phá các tiêu chuẩn tốc độ và dung lượng phù hợp cho thư viện game của bạn.
                    </p>
                    <a href="#" class="inline-flex items-center text-cyber-white font-bold uppercase tracking-widest text-xs hover:text-cyber-text-muted transition-colors">
                        [READ_MORE] <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
            
            <!-- Blog Post 4 -->
            <div class="bg-cyber-black border border-cyber-border group hover:border-cyber-white transition-colors duration-300">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-cyber-text-muted uppercase tracking-wider">Components</span>
                        <span class="text-xs font-mono text-cyber-text-muted">29-10-2025</span>
                    </div>
                    <h2 class="text-2xl font-bold text-cyber-white mb-4 uppercase tracking-wide group-hover:text-cyber-text-muted transition-colors">
                        Hướng dẫn chọn Power Supply
                    </h2>
                    <p class="text-cyber-text mb-6 font-light leading-relaxed line-clamp-3">
                        Nguồn điện chất lượng là yếu tố quan trọng để đảm bảo độ bền của máy tính. Đừng để bộ nguồn kém chất lượng làm hỏng dàn PC đắt tiền của bạn.
                    </p>
                    <a href="#" class="inline-flex items-center text-cyber-white font-bold uppercase tracking-widest text-xs hover:text-cyber-text-muted transition-colors">
                        [READ_MORE] <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
