/**
 * Multi-Language Support System
 * Languages: English (default), Korean, Japanese, Chinese
 */

const translations = {
    en: {
        // Navigation
        nav_home: "Home",
        nav_shop: "Shop",
        nav_about: "About Us",
        nav_request_quote: "Request Quote",
        nav_contact: "Contact Us",
        nav_cart: "Cart",

        // Home Page Quote Section
        home_quote_title: "Request a Quote",
        home_quote_subtitle: "Get competitive pricing for industrial equipment and parts. Fill out the form and our team will respond within 24 hours.",
        home_quote_benefit1: "✓ Customized pricing for your business",
        home_quote_benefit2: "✓ Access to worldwide suppliers",
        home_quote_benefit3: "✓ Expert technical support",
        home_quote_benefit4: "✓ Fast turnaround time",
        home_quote_button: "Get Your Quote Now",

        // Hero Section
        hero_title: "Global Industrial Solutions",
        hero_subtitle: "Your Trusted Partner for Industrial Machinery, Equipment & Parts",
        hero_cta_primary: "Browse Products",
        hero_cta_secondary: "Request Quote",

        // Features
        features_title: "Why Choose ONCUBE GLOBAL",
        feature1_title: "Global Sourcing",
        feature1_desc: "Access to worldwide industrial products from trusted suppliers",
        feature2_title: "Competitive Pricing",
        feature2_desc: "Direct pricing from manufacturers with transparent quotation system",
        feature3_title: "Expert Support",
        feature3_desc: "Dedicated B2B team to handle all your industrial procurement needs",

        // Products Section
        products_title: "Featured Products",
        products_subtitle: "High-quality industrial machinery and equipment",
        products_view_all: "View All Products",

        // Product Card
        product_rfq: "Request Quote",
        product_add_cart: "Add to Cart",
        product_original_price: "Original Price",

        // Categories
        categories_title: "Product Categories",
        category_machinery: "Industrial Machinery",
        category_equipment: "Equipment & Tools",
        category_parts: "Parts & Components",
        category_materials: "Raw Materials",

        // About Section
        about_title: "About ONCUBE GLOBAL",
        about_content: "ONCUBE GLOBAL is a leading B2B platform specializing in industrial machinery, equipment, and parts. We connect businesses worldwide with quality industrial products at competitive prices.",
        about_mission_title: "Our Mission",
        about_mission_content: "To streamline global industrial procurement by providing transparent pricing, reliable sourcing, and exceptional customer service.",

        // Contact Section
        contact_title: "Get In Touch",
        contact_subtitle: "Ready to source your industrial needs? Contact us today",
        contact_cta: "Contact Us",
        contact_rfq: "Request Quote",

        // Footer
        footer_copyright: "© 2025 ONCUBE GLOBAL. All rights reserved.",
        footer_quick_links: "Quick Links",
        footer_contact_info: "Contact Information",

        // Shop Page
        shop_title: "Industrial Products",
        shop_filter: "Filter",
        shop_sort: "Sort by",
        shop_showing: "Showing",
        shop_products: "products",

        // Cart
        cart_title: "Shopping Cart",
        cart_empty: "Your cart is empty",
        cart_item: "Item",
        cart_quantity: "Quantity",
        cart_remove: "Remove",
        cart_rfq_all: "Request Quote for All Items",
        cart_clear: "Clear Cart",

        // RFQ Form
        rfq_title: "Request for Quote",
        rfq_product: "Product",
        rfq_name: "Your Name",
        rfq_email: "Email Address",
        rfq_company: "Company Name",
        rfq_phone: "Phone Number",
        rfq_quantity: "Quantity Needed",
        rfq_message: "Additional Requirements",
        rfq_submit: "Submit Request",
        rfq_success: "Your quote request has been submitted successfully!",

        // Request Quote Page
        quote_page_title: "Request a Quote",
        quote_page_subtitle: "Get competitive pricing for industrial equipment and parts. Fill out the form and our team will respond within 24 hours.",
        quote_page_intro: "What you'll get:",
        quote_benefit_1: "Customized pricing for your business needs",
        quote_benefit_2: "Access to worldwide suppliers and inventory",
        quote_benefit_3: "Expert technical support and consultation",
        quote_benefit_4: "Fast turnaround time - 24 hour response",
        quote_benefit_5: "Volume discounts for bulk orders",
        quote_benefit_6: "International shipping quotes available",
        quote_trusted_title: "Trusted by businesses worldwide",
        
        // Quote Form Fields
        quote_email_label: "Work Email Address",
        quote_company_label: "Company Name",
        quote_phone_label: "Phone Number",
        quote_contact_label: "Contact Name",
        quote_product_url_label: "Product URL",
        quote_inquiry_type_label: "Inquiry Type",
        quote_inquiry_select: "Please Select",
        quote_inquiry_quote: "Quote Inquiry",
        quote_inquiry_bulk: "Bulk Purchase",
        quote_inquiry_partnership: "Business Partnership",
        quote_inquiry_other: "Other",
        quote_quantity_label: "Quantity",
        quote_quantity_placeholder: "e.g., 10 units",
        quote_message_label: "Message",
        quote_attachment_label: "File Attachment",
        quote_attachment_help: "Max 10MB, PDF, DOC, DOCX, XLS, XLSX, JPG, PNG formats",
        quote_privacy_title: "Privacy Policy Consent",
        quote_privacy_items: "Collected Items: Company name, contact name, phone number, email",
        quote_privacy_purpose: "Collection Purpose: To respond to business purchase and quote inquiries and provide consultation",
        quote_privacy_retention: "Retention Period: 3 years from the date of inquiry (stored in accordance with relevant laws)",
        quote_privacy_notice: "Notice: You can refuse the collection and use of personal information, but refusal may limit inquiry reception and responses.",
        quote_privacy_agree: "I agree to the collection and use of personal information (Required)",
        quote_submit_btn: "Submit Quote Request",
        quote_privacy_alert: "Please agree to the collection and use of personal information.",

        // Contact Form
        contact_form_title: "Send us a Message",
        contact_name: "Name",
        contact_email: "Email",
        contact_subject: "Subject",
        contact_message: "Message",
        contact_send: "Send Message",

        // Misc
        currency: "USD",
        read_more: "Read More",
        learn_more: "Learn More",
        loading: "Loading...",
    },

    ko: {
        // Navigation
        nav_home: "홈",
        nav_shop: "제품",
        nav_about: "회사소개",
        nav_request_quote: "견적요청",
        nav_contact: "문의하기",
        nav_cart: "장바구니",

        // Home Page Quote Section
        home_quote_title: "견적 요청",
        home_quote_subtitle: "산업용 장비 및 부품에 대한 경쟁력 있는 가격을 받아보세요. 양식을 작성하시면 24시간 내에 답변 드립니다.",
        home_quote_benefit1: "✓ 귀사를 위한 맞춤형 가격",
        home_quote_benefit2: "✓ 전 세계 공급업체 접근",
        home_quote_benefit3: "✓ 전문 기술 지원",
        home_quote_benefit4: "✓ 빠른 처리 시간",
        home_quote_button: "지금 견적 받기",

        // Hero Section
        hero_title: "글로벌 산업 솔루션",
        hero_subtitle: "산업용 기계, 장비 및 부품을 위한 신뢰할 수 있는 파트너",
        hero_cta_primary: "제품 둘러보기",
        hero_cta_secondary: "견적 요청",

        // Features
        features_title: "ONCUBE GLOBAL을 선택하는 이유",
        feature1_title: "글로벌 소싱",
        feature1_desc: "신뢰할 수 있는 공급업체의 전세계 산업용 제품에 대한 액세스",
        feature2_title: "경쟁력 있는 가격",
        feature2_desc: "투명한 견적 시스템을 통한 제조업체의 직접 가격",
        feature3_title: "전문가 지원",
        feature3_desc: "모든 산업 조달 요구사항을 처리하는 전담 B2B 팀",

        // Products Section
        products_title: "추천 제품",
        products_subtitle: "고품질 산업용 기계 및 장비",
        products_view_all: "모든 제품 보기",

        // Product Card
        product_rfq: "견적 요청",
        product_add_cart: "장바구니 담기",
        product_original_price: "현지 가격",

        // Categories
        categories_title: "제품 카테고리",
        category_machinery: "산업용 기계",
        category_equipment: "장비 및 도구",
        category_parts: "부품 및 구성요소",
        category_materials: "원자재",

        // About Section
        about_title: "ONCUBE GLOBAL 소개",
        about_content: "ONCUBE GLOBAL은 산업용 기계, 장비 및 부품을 전문으로 하는 선도적인 B2B 플랫폼입니다. 전 세계 기업을 경쟁력 있는 가격의 고품질 산업용 제품과 연결합니다.",
        about_mission_title: "우리의 미션",
        about_mission_content: "투명한 가격 책정, 안정적인 소싱 및 탁월한 고객 서비스를 제공하여 글로벌 산업 조달을 간소화합니다.",

        // Contact Section
        contact_title: "문의하기",
        contact_subtitle: "산업 조달이 필요하신가요? 지금 문의하세요",
        contact_cta: "문의하기",
        contact_rfq: "견적 요청",

        // Footer
        footer_copyright: "© 2025 ONCUBE GLOBAL. 모든 권리 보유.",
        footer_quick_links: "빠른 링크",
        footer_contact_info: "연락처 정보",

        // Shop Page
        shop_title: "산업용 제품",
        shop_filter: "필터",
        shop_sort: "정렬",
        shop_showing: "표시 중",
        shop_products: "제품",

        // Cart
        cart_title: "장바구니",
        cart_empty: "장바구니가 비어있습니다",
        cart_item: "제품",
        cart_quantity: "수량",
        cart_remove: "삭제",
        cart_rfq_all: "전체 견적 요청",
        cart_clear: "장바구니 비우기",

        // RFQ Form
        rfq_title: "견적 요청서",
        rfq_product: "제품",
        rfq_name: "이름",
        rfq_email: "이메일",
        rfq_company: "회사명",
        rfq_phone: "전화번호",
        rfq_quantity: "필요 수량",
        rfq_message: "추가 요구사항",
        rfq_submit: "요청 제출",
        rfq_success: "견적 요청이 성공적으로 제출되었습니다!",

        // Request Quote Page
        quote_page_title: "견적 요청",
        quote_page_subtitle: "산업 장비 및 부품에 대한 경쟁력 있는 가격을 받아보세요. 양식을 작성하시면 저희 팀이 24시간 이내에 응답해 드립니다.",
        quote_page_intro: "제공 내용:",
        quote_benefit_1: "귀하의 비즈니스 요구에 맞춤화된 가격",
        quote_benefit_2: "전 세계 공급업체 및 재고에 대한 액세스",
        quote_benefit_3: "전문가 기술 지원 및 상담",
        quote_benefit_4: "빠른 처리 시간 - 24시간 응답",
        quote_benefit_5: "대량 주문 시 볼륨 할인",
        quote_benefit_6: "국제 배송 견적 가능",
        quote_trusted_title: "전 세계 기업들의 신뢰",
        
        // Quote Form Fields
        quote_email_label: "회사 이메일 주소",
        quote_company_label: "회사명",
        quote_phone_label: "휴대폰 번호",
        quote_contact_label: "담당자명",
        quote_product_url_label: "구매 희망 상품 URL",
        quote_inquiry_type_label: "문의 유형",
        quote_inquiry_select: "선택해주세요",
        quote_inquiry_quote: "견적문의",
        quote_inquiry_bulk: "대량구매",
        quote_inquiry_partnership: "사업제휴",
        quote_inquiry_other: "기타",
        quote_quantity_label: "구매 희망 수량",
        quote_quantity_placeholder: "예: 10개",
        quote_message_label: "문의 내용",
        quote_attachment_label: "파일 첨부",
        quote_attachment_help: "최대 10MB, PDF, DOC, DOCX, XLS, XLSX, JPG, PNG 형식",
        quote_privacy_title: "개인정보 수집 및 이용 동의",
        quote_privacy_items: "수집 항목: 회사명, 담당자명, 휴대폰번호, 이메일",
        quote_privacy_purpose: "수집 목적: 사업자 구매 및 견적 문의에 대한 답변 및 상담 진행",
        quote_privacy_retention: "보유 기간: 문의 접수일로부터 3년 (관련 법령에 따라 보관)",
        quote_privacy_notice: "안내: 귀하는 개인정보 수집·이용을 거부할 수 있으며, 거부 시 문의 접수 및 답변이 제한될 수 있습니다.",
        quote_privacy_agree: "개인정보 수집 및 이용에 동의합니다 (필수)",
        quote_submit_btn: "견적 요청 제출",
        quote_privacy_alert: "개인정보 수집 및 이용에 동의해주세요.",

        // Contact Form
        contact_form_title: "메시지 보내기",
        contact_name: "이름",
        contact_email: "이메일",
        contact_subject: "제목",
        contact_message: "메시지",
        contact_send: "메시지 전송",

        // Misc
        currency: "USD",
        read_more: "더 보기",
        learn_more: "자세히 보기",
        loading: "로딩 중...",
    },

    ja: {
        // Navigation
        nav_home: "ホーム",
        nav_shop: "製品",
        nav_about: "会社概要",
        nav_request_quote: "見積依頼",
        nav_contact: "お問い合わせ",
        nav_cart: "カート",

        // Home Page Quote Section
        home_quote_title: "お見積り依頼",
        home_quote_subtitle: "産業機器や部品の競争力のある価格をご案内します。フォームにご記入いただければ、24時間以内にご返答いたします。",
        home_quote_benefit1: "✓ お客様のビジネスに合わせた価格設定",
        home_quote_benefit2: "✓ 世界中のサプライヤーへのアクセス",
        home_quote_benefit3: "✓ 専門的な技術サポート",
        home_quote_benefit4: "✓ 迅速な対応時間",
        home_quote_button: "今すぐ見積もりを取得",

        // Hero Section
        hero_title: "グローバル産業ソリューション",
        hero_subtitle: "産業機械、設備、部品のための信頼できるパートナー",
        hero_cta_primary: "製品を見る",
        hero_cta_secondary: "見積依頼",

        // Features
        features_title: "ONCUBE GLOBALを選ぶ理由",
        feature1_title: "グローバル調達",
        feature1_desc: "信頼できるサプライヤーからの世界中の産業製品へのアクセス",
        feature2_title: "競争力のある価格",
        feature2_desc: "透明な見積システムによるメーカー直接価格",
        feature3_title: "専門サポート",
        feature3_desc: "すべての産業調達ニーズに対応する専任B2Bチーム",

        // Products Section
        products_title: "おすすめ製品",
        products_subtitle: "高品質な産業機械および設備",
        products_view_all: "すべての製品を見る",

        // Product Card
        product_rfq: "見積依頼",
        product_add_cart: "カートに追加",
        product_original_price: "現地価格",

        // Categories
        categories_title: "製品カテゴリ",
        category_machinery: "産業機械",
        category_equipment: "設備・工具",
        category_parts: "部品・コンポーネント",
        category_materials: "原材料",

        // About Section
        about_title: "ONCUBE GLOBALについて",
        about_content: "ONCUBE GLOBALは、産業機械、設備、部品を専門とする主要なB2Bプラットフォームです。競争力のある価格で高品質な産業製品を世界中の企業に提供しています。",
        about_mission_title: "私たちの使命",
        about_mission_content: "透明な価格設定、信頼できる調達、優れた顧客サービスを提供することで、グローバルな産業調達を合理化します。",

        // Contact Section
        contact_title: "お問い合わせ",
        contact_subtitle: "産業調達のニーズがありますか？今すぐお問い合わせください",
        contact_cta: "お問い合わせ",
        contact_rfq: "見積依頼",

        // Footer
        footer_copyright: "© 2025 ONCUBE GLOBAL. 全著作権所有。",
        footer_quick_links: "クイックリンク",
        footer_contact_info: "連絡先情報",

        // Shop Page
        shop_title: "産業製品",
        shop_filter: "フィルター",
        shop_sort: "並び替え",
        shop_showing: "表示中",
        shop_products: "製品",

        // Cart
        cart_title: "ショッピングカート",
        cart_empty: "カートは空です",
        cart_item: "商品",
        cart_quantity: "数量",
        cart_remove: "削除",
        cart_rfq_all: "すべての商品の見積依頼",
        cart_clear: "カートをクリア",

        // RFQ Form
        rfq_title: "見積もり依頼",
        rfq_product: "製品",
        rfq_name: "お名前",
        rfq_email: "メールアドレス",
        rfq_company: "会社名",
        rfq_phone: "電話番号",
        rfq_quantity: "必要数量",
        rfq_message: "追加要件",
        rfq_submit: "依頼を送信",
        rfq_success: "見積もり依頼が正常に送信されました！",

        // Request Quote Page
        quote_page_title: "見積もり依頼",
        quote_page_subtitle: "産業機器および部品の競争力のある価格を取得します。フォームに記入すると、当社のチームが24時間以内に対応いたします。",
        quote_page_intro: "提供内容:",
        quote_benefit_1: "ビジネスニーズに合わせたカスタマイズ価格",
        quote_benefit_2: "世界中のサプライヤーと在庫へのアクセス",
        quote_benefit_3: "専門家による技術サポートとコンサルティング",
        quote_benefit_4: "迅速な対応時間 - 24時間以内の回答",
        quote_benefit_5: "大量注文時のボリュームディスカウント",
        quote_benefit_6: "国際配送の見積もり可能",
        quote_trusted_title: "世界中の企業から信頼されています",
        
        // Quote Form Fields
        quote_email_label: "会社メールアドレス",
        quote_company_label: "会社名",
        quote_phone_label: "携帯電話番号",
        quote_contact_label: "担当者名",
        quote_product_url_label: "購入希望製品URL",
        quote_inquiry_type_label: "お問い合わせタイプ",
        quote_inquiry_select: "選択してください",
        quote_inquiry_quote: "見積もり依頼",
        quote_inquiry_bulk: "大量購入",
        quote_inquiry_partnership: "事業提携",
        quote_inquiry_other: "その他",
        quote_quantity_label: "購入希望数量",
        quote_quantity_placeholder: "例：10個",
        quote_message_label: "お問い合わせ内容",
        quote_attachment_label: "ファイル添付",
        quote_attachment_help: "最大10MB、PDF、DOC、DOCX、XLS、XLSX、JPG、PNG形式",
        quote_privacy_title: "個人情報の収集及び利用同意",
        quote_privacy_items: "収集項目: 会社名、担当者名、携帯電話番号、メールアドレス",
        quote_privacy_purpose: "収集目的: 事業者の購入及び見積もり相談に対する回答及び相談進行",
        quote_privacy_retention: "保有期間: お問い合わせ受付日から3年（関連法令に基づき保管）",
        quote_privacy_notice: "ご案内: 個人情報の収集・利用を拒否することができますが、拒否された場合、お問い合わせ受付及び回答が制限される可能性があります。",
        quote_privacy_agree: "個人情報の収集及び利用に同意します（必須）",
        quote_submit_btn: "見積もり依頼を送信",
        quote_privacy_alert: "個人情報の収集及び利用に同意してください。",

        // Contact Form
        contact_form_title: "メッセージを送る",
        contact_name: "名前",
        contact_email: "メール",
        contact_subject: "件名",
        contact_message: "メッセージ",
        contact_send: "メッセージを送信",

        // Misc
        currency: "USD",
        read_more: "続きを読む",
        learn_more: "詳細を見る",
        loading: "読み込み中...",
    },

    zh: {
        // Navigation
        nav_home: "首页",
        nav_shop: "产品",
        nav_about: "关于我们",
        nav_request_quote: "请求报价",
        nav_contact: "联系我们",
        nav_cart: "购物车",

        // Home Page Quote Section
        home_quote_title: "请求报价",
        home_quote_subtitle: "获取工业设备和零件的竞争性价格。填写表格，我们的团队将在24小时内回复您。",
        home_quote_benefit1: "✓ 为您的企业定制价格",
        home_quote_benefit2: "✓ 访问全球供应商",
        home_quote_benefit3: "✓ 专家技术支持",
        home_quote_benefit4: "✓ 快速周转时间",
        home_quote_button: "立即获取报价",

        // Hero Section
        hero_title: "全球工业解决方案",
        hero_subtitle: "您值得信赖的工业机械、设备和零件合作伙伴",
        hero_cta_primary: "浏览产品",
        hero_cta_secondary: "询价",

        // Features
        features_title: "选择ONCUBE GLOBAL的理由",
        feature1_title: "全球采购",
        feature1_desc: "访问来自可信供应商的全球工业产品",
        feature2_title: "有竞争力的价格",
        feature2_desc: "通过透明报价系统直接从制造商获取价格",
        feature3_title: "专家支持",
        feature3_desc: "专门的B2B团队处理您的所有工业采购需求",

        // Products Section
        products_title: "精选产品",
        products_subtitle: "高质量工业机械和设备",
        products_view_all: "查看所有产品",

        // Product Card
        product_rfq: "询价",
        product_add_cart: "加入购物车",
        product_original_price: "当地价格",

        // Categories
        categories_title: "产品类别",
        category_machinery: "工业机械",
        category_equipment: "设备和工具",
        category_parts: "零件和组件",
        category_materials: "原材料",

        // About Section
        about_title: "关于ONCUBE GLOBAL",
        about_content: "ONCUBE GLOBAL是专门从事工业机械、设备和零件的领先B2B平台。我们以有竞争力的价格将全球企业与优质工业产品联系起来。",
        about_mission_title: "我们的使命",
        about_mission_content: "通过提供透明的定价、可靠的采购和卓越的客户服务，简化全球工业采购。",

        // Contact Section
        contact_title: "联系我们",
        contact_subtitle: "准备采购您的工业需求？立即联系我们",
        contact_cta: "联系我们",
        contact_rfq: "询价",

        // Footer
        footer_copyright: "© 2025 ONCUBE GLOBAL. 版权所有。",
        footer_quick_links: "快速链接",
        footer_contact_info: "联系信息",

        // Shop Page
        shop_title: "工业产品",
        shop_filter: "筛选",
        shop_sort: "排序",
        shop_showing: "显示",
        shop_products: "产品",

        // Cart
        cart_title: "购物车",
        cart_empty: "您的购物车是空的",
        cart_item: "商品",
        cart_quantity: "数量",
        cart_remove: "删除",
        cart_rfq_all: "为所有商品询价",
        cart_clear: "清空购物车",

        // RFQ Form
        rfq_title: "报价请求",
        rfq_product: "产品",
        rfq_name: "姓名",
        rfq_email: "电子邮件",
        rfq_company: "公司名称",
        rfq_phone: "电话号码",
        rfq_quantity: "需要数量",
        rfq_message: "其他要求",
        rfq_submit: "提交请求",
        rfq_success: "您的报价请求已成功提交！",

        // Request Quote Page
        quote_page_title: "请求报价",
        quote_page_subtitle: "获取工业设备和零件的竞争价格。填写表格，我们的团队将在24小时内回复您。",
        quote_page_intro: "您将获得:",
        quote_benefit_1: "根据您的业务需求定制的价格",
        quote_benefit_2: "访问全球供应商和库存",
        quote_benefit_3: "专家技术支持和咨询",
        quote_benefit_4: "快速周转时间 - 24小时响应",
        quote_benefit_5: "批量订单的数量折扣",
        quote_benefit_6: "提供国际运输报价",
        quote_trusted_title: "受到全球企业信赖",
        
        // Quote Form Fields
        quote_email_label: "公司电子邮件地址",
        quote_company_label: "公司名称",
        quote_phone_label: "手机号码",
        quote_contact_label: "联系人姓名",
        quote_product_url_label: "期望购买产品URL",
        quote_inquiry_type_label: "咨询类型",
        quote_inquiry_select: "请选择",
        quote_inquiry_quote: "报价咨询",
        quote_inquiry_bulk: "批量采购",
        quote_inquiry_partnership: "业务合作",
        quote_inquiry_other: "其他",
        quote_quantity_label: "期望购买数量",
        quote_quantity_placeholder: "例如：10个",
        quote_message_label: "咨询内容",
        quote_attachment_label: "文件附件",
        quote_attachment_help: "最大10MB，PDF、DOC、DOCX、XLS、XLSX、JPG、PNG格式",
        quote_privacy_title: "个人信息收集及使用同意",
        quote_privacy_items: "收集项目: 公司名称、联系人姓名、手机号码、电子邮件",
        quote_privacy_purpose: "收集目的: 回复和咨询企业采购及报价咨询",
        quote_privacy_retention: "保留期限: 自咨询受理之日起3年（根据相关法律保存）",
        quote_privacy_notice: "说明: 您可以拒绝收集和使用个人信息，但拒绝时可能会限制咨询受理和回复。",
        quote_privacy_agree: "同意个人信息收集及使用（必填）",
        quote_submit_btn: "提交报价请求",
        quote_privacy_alert: "请同意个人信息收集及使用。",

        // Contact Form
        contact_form_title: "发送消息",
        contact_name: "姓名",
        contact_email: "电子邮件",
        contact_subject: "主题",
        contact_message: "消息",
        contact_send: "发送消息",

        // Misc
        currency: "USD",
        read_more: "阅读更多",
        learn_more: "了解更多",
        loading: "加载中...",
    }
};

// Current language state - now using URL-based locale instead of localStorage
let currentLanguage = document.documentElement.lang || 'en';

// Initialize language on page load
document.addEventListener('DOMContentLoaded', () => {
    // Get language from URL route parameter instead of localStorage
    const urlPath = window.location.pathname;
    const localeMatch = urlPath.match(/^\/(en|ko|ja|zh)\//);
    if (localeMatch) {
        currentLanguage = localeMatch[1];
    }

    updateLanguage(currentLanguage);
    // Don't call updateLanguageSelector() - let server-side rendering handle active state
});

// Change language
function changeLanguage(lang) {
    currentLanguage = lang;
    localStorage.setItem('language', lang);
    updateLanguage(lang);
    updateLanguageSelector();
}

// Update all text content
function updateLanguage(lang) {
    const elements = document.querySelectorAll('[data-i18n]');
    elements.forEach(element => {
        const key = element.getAttribute('data-i18n');
        if (translations[lang] && translations[lang][key]) {
            element.textContent = translations[lang][key];
        }
    });

    // Update placeholders
    const placeholders = document.querySelectorAll('[data-i18n-placeholder]');
    placeholders.forEach(element => {
        const key = element.getAttribute('data-i18n-placeholder');
        if (translations[lang] && translations[lang][key]) {
            element.placeholder = translations[lang][key];
        }
    });

    // Update HTML lang attribute
    document.documentElement.lang = lang;
}

// Update language selector active state
function updateLanguageSelector() {
    const selectors = document.querySelectorAll('.lang-selector');
    selectors.forEach(selector => {
        if (selector.getAttribute('data-lang') === currentLanguage) {
            selector.classList.add('active');
        } else {
            selector.classList.remove('active');
        }
    });
}

// Get translation
function t(key) {
    return translations[currentLanguage][key] || key;
}

// Export for use in other files
window.changeLanguage = changeLanguage;
window.t = t;
window.currentLanguage = currentLanguage;
