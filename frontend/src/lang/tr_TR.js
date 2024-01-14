export default {
    HOME: {
        HEADER: {
            TOP_TITLE: 'POWERLOAD NEDİR?',
            TITLE: 'Progressive Overload <br> ağırlıklarınla birlikte büyü ',
            DESCRIPTION_TEXT_1: 'Progressive Overload belirli bir dönem içinde sürekli olarak <b>ağırlık/tekrar </b> arttırarak <b>güç ve kas</b> kazanımında fayda sağlayan bir metoddur.',
            DESCRIPTION_TEXT_2: 'Bu uygulama ile <b>antrenmanlarını</b> ve <b>ağırlıklarını</b> kolayca takip edebiliceksin!'
        }, 
        STEPS: {
            1: {
                TITLE: 'Üye Ol',
                DESCRIPTION: 'Ücretsiz bir şekilde üyeliğini oluşturabilir ve uygulamayı kullanmaya başlayabilirsin.'
            },
            2: {
                TITLE: 'Antrenman Yap',
                DESCRIPTION: 'En iyi sonuçları sadece düzenli antrenman yaparak alabilirsin!'
            },
            3: {
                TITLE: 'Notunu Al',
                DESCRIPTION: ' Antrenmanda güçlenmek istediğin hareketlerde ağırlıkları ve tekrarları not al.'
            },
            4: {
                TITLE: 'Analiz Et!',
                DESCRIPTION: ' Geçmişe dönük kaldırdığın ağırlıkların artışlarını takip edip ilerlemeni analiz et!'
            },
        },
        DOWNLOAD_TEXT : 'Uygulamayı indirin ve antrenmanlarınızı takip edin!',
    },
    SIDEBAR: {
        MENU: {
            HOME: 'Anasayfa',
            ABOUT: 'Hakkımızda',
            DASHBOARD: 'Genel Bakış',
            TRAINING_LIST: 'Antrenman Listesi',
            TRAINING_HISTORY: 'Antrenman Geçmişi',
            RESET_PASSWORD: 'Şifre Yenile',
            PROFILE_SETTINGS: 'Profil Ayarları',
        },
        AUTH: {
            FOR_MORE_INFO: 'Daha fazla bilgi için',
            GO_LOGIN: 'giriş yapın!',
            MY_ACCOUNT: 'Hesabım',
            LOGOUT: 'Çıkış Yap',
            LOGIN: 'Giriş Yap',
            OR: 'veya',
            REGISTER: 'Kayıt Ol',
        }
    },
    DASHBOARD: {
        TITLE: 'Genel Bakış',
        TOP_STATS: {
            TRAINING: 'Antrenman',
            AVG_TIME: 'Ortalama Süre',
            AVG_EXERCISE: 'Ortalama Hareket',
            X: '?',
            SUBTITLE : '*Bu veriler yalnızca <b>tamamlanmış</b> antrenmanlardan hesaplanmaktadır.'
        },
        CHART: {
            TITLE: 'Harekete göre ağırlık grafiği',
            FREQUENCY: 'Grafik Aralığı',
            EXERCISE: 'Egzersiz',
            NO_DATA_MESSAGE : 'Bu hareket için henüz veri bulunmamaktadır.',
            FREQUENCY_OPTIONS: {
                YEARLY: {
                    TEXT: 'Yıllık',
                    VALUE: '1'
                },
                MONTHLY: {
                    TEXT: 'Aylık',
                    VALUE: '2'
                },
                WEEKLY:{
                    TEXT: 'Haftalık',
                    VALUE: '3'
                }
            }
        },
        LAST_TRAININGS: {
            TITLE: 'Son 5 antrenman',
            SEE_ALL: 'tümünü gör',
            TIME: 'süre',
            STATUS: {
                CONTINUE: 'Devam Ediyor',
                COMPLETED: 'Tamamlandı',
                CANCELED: 'İptal Edildi'
            }
        },
        PERSONAL_RECORDS: {
            TITLE: 'Kişisel Rekorlar (PR)',
            TABLE: {
                EXERCISE: 'Egzersiz Adı',
                CATEGORY: 'Egzersiz Kategorisi',
                WEIGHT: 'PR (KG)',
                DATE: 'Tarih',
                SEE: 'İncele',
            },
            NO_PR: 'Henüz antrenman yapmadığınız için kişisel rekorunuz bulunmamaktadır.'
        }
    },
    TRAININGS: {
        LIST: {
            TITLE: 'Antrenmanlar',
            DESCRIPTION: 'Antrenmanların burada listelenir yeni antrenman ekleyebilir ve bunların içine antrenman günleri ve hareketler ekleyebilirsin.',
            ADD_BUTTON: 'Antrenman Ekle',
            EDIT_BUTTON: 'Düzenle',
            DELETE_BUTTON: 'Sil',
            TABLE: {
                TRAINING_NAME:  'Antrenman Adı',
                APPLIED_DAY: 'Uygulanan Gün',
                CREATED_AT: 'Oluşturulma Tarihi',
                ACTIONS:  'İşlemler',
            },
            NO_DATA: 'Henüz antrenman eklemedin! Antrenman ekleyip gücüne güç katmaya başlayabilirsin!',
            DELETE_ACTION: {
                TITLE: 'Emin misin?',
                TEXT: 'Bu antrenmanı silmek istediğine emin misin? Bu işlem geri alınamaz!',
                CONFIRM_BUTTON: 'Evet, sil!',
                CANCEL_BUTTON: 'Hayır, iptal et!',
                SUCCESS: 'Antrenman başarıyla silindi!',
            }
        },
        ADD: {
            BACK_TRAININGS: 'Antrenmanlara Dön',
            TITLE: 'Antrenman Ekle',
            DESCRIPTION: 'Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin!',
        },
        EDIT: {
            BACK_TRAININGS: 'Antrenmanlara Dön',
            TITLE: 'Antrenman Düzenle',
            DESCRIPTION: 'Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin!',
        },
        TRAIN_BUILDER: {
            TRAINING_NAME: 'Antrenman Adı',
            TRAINING_NAME_PLACEHOLDER: 'Antrenman Adı Giriniz',
            DAY: 'Gün',
            DAY_PLACEHOLDER: 'Gün Adı Giriniz',
            DAY_EMPTY_ERROR: 'Gün adı boş bırakılamaz!',
            NO_TRAINING_DAY_ERROR: 'Antrenman günü olmadan antrenman eklenemez!',
            MULTIPLE_SELECT_EXERCISE: 'Her egzersiz gün içinde 1 kez seçilebilir!',
            SELECT_EXERCISE: 'Egzersiz Seçiniz',
            EXERCISE: 'Egzersiz',
            SET: 'Set',
            REP: 'Tekrar',
            ADD_EXERCISE: 'Egzersiz Ekle',
            ADD_DAY: 'Antrenman Günü Ekle',
            VALIDATION_ERROR: 'Lütfen hatalı veya eksik alanarı düzeltin!',
            SUBMIT_FORM: 'ANTRENMANI KAYDET',
        }
    },
    TRAINING_HISTORY : {
        LIST: {
            TITLE: 'Antrenman Geçmişi',
            DESCRIPTION: 'Antrenman geçmişiniz bu sayfada listelenir 👀',
            TABLE: {
                NAME:  'Antrenman',
                DURATION: 'Antrenman Süresi',
                DATE: 'Antrenman Tarihi',
                SEE:  'İncele',
            },
            SEE_BUTTON: 'Detaylı İncele',
            NO_DATA: 'Henüz antrenman yapmadınız! Antrenman yapmaya başlayıp gücüne güç katmaya başlayabilirsin!',
        },
        SHOW: {
            BACK_TO_LIST: 'Listeye Dön',
            TITLE: 'Antrenman Detayları',
            DESCRIPTION: 'Antrenmanınızın detayları burada listelenir.',
        }
    },
    TRAIN_RESULT: {
        TRAINING: 'Antrenman',
        DURATION: 'Süre',
        EXERCISES: 'Egzersizler',
        SET: 'Set',
        KG: 'KG'
    },
    RESET_PASSWORD: {
        TITLE: 'Şifre Yenile',
        DESCRIPTION: 'Şifre oluştururken en az 6 karakter, büyük ve küçük harflerden oluşmasına dikkat etmelisiniz. Zorunlu değil sadece tavsiye 🙃',
        FORM: {
            CURRENT_PASSWORD: {
                LABEL: 'Mevcut Şifre',
                PLACEHOLDER: 'Mevcut Şifrenizi Giriniz',
                EMPTY_ERROR: 'Mevcut şifre boş bırakılamaz!',
            },
            NEW_PASSWORD: {
                LABEL: 'Yeni Şifre',
                PLACEHOLDER: 'Yeni Şifrenizi Giriniz',
                EMPTY_ERROR: 'Yeni şifre boş bırakılamaz!',
            },
            NEW_PASSWORD_CONFIRMATION: {
                LABEL: 'Yeni Şifre Tekrar',
                PLACEHOLDER: 'Yeni Şifrenizi Tekrar Giriniz',
                EMPTY_ERROR: 'Yeni şifre tekrar boş bırakılamaz!',
                MATCH_ERROR: 'Şifreler eşleşmiyor!',
            },
            SUBMIT_BUTTON: 'Şifreyi Güncelle',
            SUCCESS_MESSAGE: 'Şifreniz başarıyla güncellendi!',
        }
    },
    PROFILE_SETTINGS: {
        TITLE: 'Profil Ayarları',
        DESCRIPTION: 'Hitap edebilmemiz için ismin, iletişime geçmemiz için e-posta adresin hepsi bu kadar.',
        FORM: {
            NAME: {
                LABEL: 'Ad Soyad',
                PLACEHOLDER: 'Adınızı girin',
                EMPTY_ERROR: 'Ad Soyad boş bırakılamaz',
                CHAR_LIMIT_ERROR : 'Ad Soyad en az 2 en fazla 50 karakter olabilir',
            },
            EMAIL: {
                LABEL: 'E-Posta',
                PLACEHOLDER: 'E-Postanızı Giriniz',
                EMPTY_ERROR: 'E-Posta adresi boş bırakılamaz!',
                INVALID_ERROR: 'Geçersiz e-posta adresi!',
            },
            SUBMIT_BUTTON: 'Bilgileri Güncelle',
            SUCCESS_MESSAGE: 'Bilgileriniz başarıyla güncellendi!',
        }
    }
}