 class Applicant {
    constructor(firstName, lastName, phone, dob, site, division) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.dob = dob;
        this.phone = phone;
        this.site = site;
        this.division = division;
    }

     toFormData(user) {
        let formData = {};
        formData['firstName'] = this.firstName;
        formData['lastName'] = this.lastName;
        formData['phone'] = this.phone;
        formData['dob'] = this.dob;
        formData['site'] = this.site;
        formData['division'] = this.division;
        formData['userId'] = user;
        return formData;
    }


}