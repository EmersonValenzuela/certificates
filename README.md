<div align="center">
  <br />
  <a href="https://i.postimg.cc/6Qb5ZXGx/dozer.png" target="_blank">
    <img src="https://i.postimg.cc/6Qb5ZXGx/dozer.png" alt="Sistema de Certificados Banner" width="600"/>
  </a>
  <br />

  <div>
    <img src="https://img.shields.io/badge/-PHP-black?style=for-the-badge&logo=php&logoColor=white&color=777BB4" alt="PHP" />
    <img src="https://img.shields.io/badge/-Laravel-black?style=for-the-badge&logo=laravel&logoColor=white&color=FF2D20" alt="Laravel" />
    <img src="https://img.shields.io/badge/-JavaScript-black?style=for-the-badge&logo=javascript&logoColor=white&color=F0DB4F" alt="JavaScript" />
    <img src="https://img.shields.io/badge/-Blade-black?style=for-the-badge&logo=laravel&logoColor=white&color=FF2D20" alt="Blade" />
    <img src="https://img.shields.io/badge/-HTML-black?style=for-the-badge&logo=html5&logoColor=white&color=E44D26" alt="HTML" />
    <img src="https://img.shields.io/badge/-CSS-black?style=for-the-badge&logo=css3&logoColor=white&color=1572B6" alt="CSS" />
    <img src="https://img.shields.io/badge/-FPDF-black?style=for-the-badge&logoColor=white&color=4B8BBE" alt="FPDF" />
    <img src="https://img.shields.io/badge/-QRCodeMonkey-black?style=for-the-badge&logoColor=white&color=2E7D32" alt="QRCodeMonkey" />
  </div>

  <h2 align="center">Sistema de Generación de Certificados 📜</h2>
  <p align="center">
    Genera certificados personalizados en lote para cursos, webinars, matrículas y reconocimientos de excelencia.<br>
    Carga plantillas, importa estudiantes desde Excel y descarga PDFs con QR de validación.<br>
    <b>Ideal para instituciones educativas, academias, y marcas que imparten formación en BIM y arquitectura.</b>
  </p>
</div>

---

## 📋 Tabla de Contenidos

1. [Introducción](#introducción)
2. [Tech Stack](#tech-stack)
3. [Características](#características)
4. [Instalación Rápida](#instalación-rápida)
5. [Uso Básico](#uso-básico)
6. [Formato del Excel](#formato-del-excel)
7. [Personalización](#personalización)
8. [Contribución](#contribución)
9. [Licencia](#licencia)

---

## <a name="introducción">🤖 Introducción</a>

Este sistema nació de la necesidad de automatizar la generación de certificados para estudiantes en cursos de BIM y arquitectura. Permite gestión y envío masivo de certificados por distintas modalidades (webinar, matrícula, excelencia, etc.), todo de forma personalizada y eficiente, usando plantillas propias y datos cargados en lote.

---

## <a name="tech-stack">⚙️ Tech Stack</a>

- **PHP** + **Laravel** (backend, lógica de negocio y generación de PDFs)
- **Blade** (vistas)
- **JavaScript** (procesamiento de Excel y UI)
- **FPDF** (generación del PDF)
- **QRCodeMonkey** (generación de QR)
- **HTML & CSS** (estructura y estilos)

---

## <a name="características">🔋 Características</a>

- **Carga de plantillas personalizadas**: Sube imágenes para las páginas de tu certificado.
- **Importación masiva desde Excel**: Añade lotes de estudiantes y sus datos.
- **Generación de certificados en lote**: Crea PDFs individuales para cada estudiante.
- **QR de validación**: Cada certificado incluye un QR con link único.
- **Gestión visual de cursos y progreso**: Visualiza el estado y avance de los envíos.
- **Preparado para envío masivo por correo**.

---

## <a name="instalación-rápida">🤸 Instalación Rápida</a>

**Requisitos Previos**

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js y npm](https://nodejs.org/) (opcional para assets)

**Pasos**

1. Clona el repositorio:
    ```bash
    git clone https://github.com/EmersonValenzuela/certificates.git
    cd certificates
    ```
2. Instala dependencias:
    ```bash
    composer install
    ```
3. Configura tu archivo `.env` (base de datos, correo, etc).
4. Ejecuta migraciones:
    ```bash
    php artisan migrate
    ```
5. Inicia el servidor:
    ```bash
    php artisan serve
    ```

---

## <a name="uso-básico">🕸️ Uso Básico</a>

1. Accede como administrador al panel.
2. Ve a “Generar Certificados”.
3. Sube las dos imágenes de plantilla (hoja 1 y hoja 2).
4. Ingresa el título del curso.
5. Sube tu archivo Excel con los datos de los estudiantes.
6. Revisa la tabla generada.
7. Haz clic en “Generar” y descarga los PDFs.

---

## <a name="formato-del-excel">📑 Formato del Excel</a>

| dni      | nombre_alumno | curso | nota | email          
|----------|---------------|-------|------|----------------
| 87654321 | Juan Pérez    | BIM   | 18   | juan@email.com 

---

## <a name="personalización">🎨 Personalización</a>

- Modifica la ubicación de los datos en el PDF desde el controlador.
- Cambia el diseño del QR y la información mostrada.
- Añade nuevas plantillas o tipos de certificados según tu marca.

---

## <a name="contribución">🤝 Contribución</a>

¿Te interesa colaborar? Abre un issue o envía tu PR. ¡Toda mejora es bienvenida!

---

## <a name="licencia">📝 Licencia</a>

MIT

---

> ¿Dudas, sugerencias o mejoras? Contacta al autor o abre un issue en el repositorio.
