' ================================================
' Макрос для получения курсов валют с cbr.ru
' Использует XML API Центрального Банка России
' ================================================

Option Explicit

' Основная функция для получения курса валюты
Function GetCBRRate(currencyCode As String, Optional dateParam As Date) As Double
    On Error GoTo ErrorHandler
    
    Dim xmlHttp As Object
    Dim xmlDoc As Object
    Dim url As String
    Dim dateStr As String
    Dim nodes As Object
    Dim node As Object
    Dim charCode As String
    Dim value As String
    Dim nominal As Double
    
    ' Форматируем дату для запроса (дд/мм/гггг)
    If dateParam = 0 Then
        dateStr = Format(Date, "dd/mm/yyyy")
    Else
        dateStr = Format(dateParam, "dd/mm/yyyy")
    End If
    
    ' Формируем URL для запроса XML
    url = "https://www.cbr.ru/scripts/XML_daily.asp?date_req=" & dateStr
    
    ' Создаем HTTP объект
    Set xmlHttp = CreateObject("MSXML2.XMLHTTP")
    
    ' Отправляем запрос
    xmlHttp.Open "GET", url, False
    xmlHttp.send
    
    ' Проверяем статус ответа
    If xmlHttp.Status <> 200 Then
        GetCBRRate = 0
        MsgBox "Ошибка при получении данных. Код: " & xmlHttp.Status, vbCritical
        Exit Function
    End If
    
    ' Парсим XML
    Set xmlDoc = CreateObject("MSXML2.DOMDocument")
    xmlDoc.LoadXML xmlHttp.responseText
    
    ' Ищем валюту по коду
    Set nodes = xmlDoc.SelectNodes("//Valute")
    
    For Each node In nodes
        charCode = node.SelectSingleNode("CharCode").Text
        
        If UCase(charCode) = UCase(currencyCode) Then
            nominal = CDbl(node.SelectSingleNode("Nominal").Text)
            value = Replace(node.SelectSingleNode("Value").Text, ",", ".")
            GetCBRRate = CDbl(value) / nominal
            Exit Function
        End If
    Next node
    
    ' Если валюта не найдена
    GetCBRRate = 0
    MsgBox "Валюта " & currencyCode & " не найдена!", vbExclamation
    
    Exit Function
    
ErrorHandler:
    GetCBRRate = 0
    MsgBox "Ошибка: " & Err.Description, vbCritical
End Function

' Процедура для загрузки всех курсов на активный лист
Sub LoadAllCBRRates()
    On Error GoTo ErrorHandler
    
    Dim xmlHttp As Object
    Dim xmlDoc As Object
    Dim url As String
    Dim dateStr As String
    Dim nodes As Object
    Dim node As Object
    Dim ws As Worksheet
    Dim row As Long
    
    ' Получаем активный лист
    Set ws = ActiveSheet
    
    ' Запрашиваем дату (по умолчанию - сегодня)
    dateStr = Format(Date, "dd/mm/yyyy")
    
    ' Формируем URL
    url = "https://www.cbr.ru/scripts/XML_daily.asp?date_req=" & dateStr
    
    ' Создаем HTTP объект и отправляем запрос
    Set xmlHttp = CreateObject("MSXML2.XMLHTTP")
    xmlHttp.Open "GET", url, False
    xmlHttp.send
    
    If xmlHttp.Status <> 200 Then
        MsgBox "Ошибка при получении данных. Код: " & xmlHttp.Status, vbCritical
        Exit Sub
    End If
    
    ' Парсим XML
    Set xmlDoc = CreateObject("MSXML2.DOMDocument")
    xmlDoc.LoadXML xmlHttp.responseText
    
    ' Очищаем лист и создаем заголовки
    ws.Cells.Clear
    ws.Range("A1").value = "Код"
    ws.Range("B1").value = "Название"
    ws.Range("C1").value = "Номинал"
    ws.Range("D1").value = "Курс"
    ws.Range("E1").value = "Курс за 1 ед."
    ws.Range("F1").value = "Дата"
    
    ' Форматируем заголовки
    With ws.Range("A1:F1")
        .Font.Bold = True
        .Interior.Color = RGB(68, 114, 196)
        .Font.Color = RGB(255, 255, 255)
        .HorizontalAlignment = xlCenter
    End With
    
    ' Заполняем данные
    Set nodes = xmlDoc.SelectNodes("//Valute")
    row = 2
    
    For Each node In nodes
        ws.Cells(row, 1).value = node.SelectSingleNode("CharCode").Text ' Код валюты
        ws.Cells(row, 2).value = node.SelectSingleNode("Name").Text ' Название
        ws.Cells(row, 3).value = CDbl(node.SelectSingleNode("Nominal").Text) ' Номинал
        
        ' Курс (заменяем запятую на точку для правильного преобразования)
        Dim rateValue As String
        rateValue = Replace(node.SelectSingleNode("Value").Text, ",", ".")
        ws.Cells(row, 4).value = CDbl(rateValue)
        
        ' Курс за 1 единицу
        ws.Cells(row, 5).value = CDbl(rateValue) / CDbl(node.SelectSingleNode("Nominal").Text)
        ws.Cells(row, 5).NumberFormat = "0.0000"
        
        ' Дата
        ws.Cells(row, 6).value = dateStr
        
        row = row + 1
    Next node
    
    ' Автоподбор ширины колонок
    ws.Columns("A:F").AutoFit
    
    ' Добавляем границы
    With ws.Range("A1:F" & row - 1)
        .Borders.LineStyle = xlContinuous
        .Borders.Weight = xlThin
    End With
    
    MsgBox "Загружено " & (row - 2) & " курсов валют на " & dateStr, vbInformation
    
    Exit Sub
    
ErrorHandler:
    MsgBox "Ошибка: " & Err.Description, vbCritical
End Sub

' Процедура для создания дашборда с основными валютами
Sub CreateCurrencyDashboard()
    On Error GoTo ErrorHandler
    
    Dim ws As Worksheet
    Dim currencies() As String
    Dim currencyNames() As String
    Dim i As Integer
    Dim row As Long
    Dim rate As Double
    
    ' Основные валюты
    currencies = Split("USD,EUR,GBP,CNY,JPY,CHF", ",")
    currencyNames = Split("Доллар США,Евро,Фунт стерлингов,Китайский юань,Японская иена,Швейцарский франк", ",")
    
    ' Создаем новый лист
    On Error Resume Next
    Set ws = Worksheets("Курсы валют")
    If Not ws Is Nothing Then
        Application.DisplayAlerts = False
        ws.Delete
        Application.DisplayAlerts = True
    End If
    On Error GoTo ErrorHandler
    
    Set ws = Worksheets.Add
    ws.Name = "Курсы валют"
    
    ' Заголовок
    ws.Range("A1:D1").Merge
    ws.Range("A1").value = "КУРСЫ ВАЛЮТ ЦБ РФ"
    ws.Range("A1").Font.Size = 18
    ws.Range("A1").Font.Bold = True
    ws.Range("A1").HorizontalAlignment = xlCenter
    ws.Range("A1").Interior.Color = RGB(68, 114, 196)
    ws.Range("A1").Font.Color = RGB(255, 255, 255)
    ws.Range("A1").RowHeight = 40
    ws.Range("A1").VerticalAlignment = xlCenter
    
    ' Дата обновления
    ws.Range("A2").value = "Дата: " & Format(Date, "dd.mm.yyyy")
    ws.Range("A2").Font.Italic = True
    
    ' Заголовки таблицы
    row = 4
    ws.Cells(row, 1).value = "Код"
    ws.Cells(row, 2).value = "Валюта"
    ws.Cells(row, 3).value = "Курс (руб.)"
    ws.Cells(row, 4).value = "Изменение"
    
    With ws.Range("A4:D4")
        .Font.Bold = True
        .Interior.Color = RGB(217, 217, 217)
        .HorizontalAlignment = xlCenter
    End With
    
    ' Заполняем данные
    row = 5
    For i = 0 To UBound(currencies)
        rate = GetCBRRate(currencies(i))
        
        If rate > 0 Then
            ws.Cells(row, 1).value = currencies(i)
            ws.Cells(row, 2).value = currencyNames(i)
            ws.Cells(row, 3).value = rate
            ws.Cells(row, 3).NumberFormat = "0.0000"
            ws.Cells(row, 4).value = "-" ' Для истории изменений нужна база данных
            
            row = row + 1
        End If
    Next i
    
    ' Форматирование
    ws.Columns("A:D").AutoFit
    ws.Range("C5:C" & row - 1).Font.Bold = True
    ws.Range("C5:C" & row - 1).Font.Color = RGB(0, 112, 192)
    
    ' Границы
    With ws.Range("A4:D" & row - 1)
        .Borders.LineStyle = xlContinuous
        .Borders.Weight = xlThin
    End With
    
    ' Кнопка обновления
    Dim btn As Button
    Set btn = ws.Buttons.Add(10, 280, 150, 30)
    btn.Caption = "Обновить курсы"
    btn.OnAction = "CreateCurrencyDashboard"
    btn.Font.Bold = True
    
    MsgBox "Дашборд создан успешно!", vbInformation
    
    Exit Sub
    
ErrorHandler:
    MsgBox "Ошибка: " & Err.Description, vbCritical
End Sub

' Функция для использования в ячейках Excel
' Использование: =CBRCurrency("USD") или =CBRCurrency("EUR", DATE(2026,2,1))
Function CBRCurrency(currencyCode As String, Optional dateParam As Date) As Double
    CBRCurrency = GetCBRRate(currencyCode, dateParam)
End Function
