

class DateFilter {

    constructor(startDateSelector, endDateSelector, filterBtnSelector, dataDisplaySelector) {
        this.startDateInput = $(startDateSelector);
        this.endDateInput = $(endDateSelector);
        this.filterBtn = $(filterBtnSelector);
        this.dataDisplay = $(dataDisplaySelector);
        this.sampleData = [
            { id: 1, name: "Item 1", date: "2023-09-20" },
            { id: 2, name: "Item 2", date: "2023-09-22" },
            { id: 3, name: "Item 3", date: "2023-09-25" },
            { id: 4, name: "Item 4", date: "2023-10-01" },
          ];

          // initialize date pickers
          this.initDatePickers();

          this.filterBtn.on('click', () => this.handleFilter());
    }  

    initDatePickers() {
        console.log(this.startDateInput, this.endDateInput); // Check if selectors work
        this.startDateInput.datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
        });
      
        this.endDateInput.datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
        });
      }

      handleFilter() {
        const startDate = this.startDateInput.val(); 
        const endDate = this.endDateInput.val();     
      
        if (startDate && endDate) {
          this.filterData(startDate, endDate);        
        } else {
          alert("Selectionner une date de debut et de fin");
        }
      }

      filterData(startDate, endDate) {
        const filteredData = this.sampleData.filter(item => {
          return item.date >= startDate && item.date <= endDate;
        });
        this.displayData(filteredData);
      }

      //sampleData ici sera à remplacer par nos données, le filtre itère ensuite selon la demande
      displayData(data) {
        this.dataDisplay.empty();
        if (data.length === 0) {
          this.dataDisplay.append('<p>No data found for the selected date range.</p>');
        } else {
          data.forEach(item => {
            this.dataDisplay.append(`<p>${item.name} - ${item.date}</p>`);
          });
        }
      }
    }
    
    export default DateFilter;