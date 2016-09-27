class SurveysController < ApplicationController
  
  before_action :logged_in_user, only: [:create, :destroy]
  
  def show
    @survey = Survey.find(params[:id])
  end

  def new
    @survey = Survey.new
  end
  
  def index
    @surveys = Survey.all
  end
  
  def update
  end
  
  def create
    @survey = Survey.new(survey_params)
    @survey.yes = 0
    @survey.no = 0
    
    if @survey.save
      redirect_to @survey
    else
      render 'new'
    end
  end
  
  def destroy
    @survey = Survey.find(params[:id])
    @survey.destroy
    redirect_to surveys_url
  end
  
  def yes
    @survey = Survey.find(params[:survey_id])
    if(@survey.yes == nil)
      @survey.yes = 0
    else
      @survey.yes+=1
    end
    @survey.save
    redirect_to surveys_url
  end
  
  def no
    @survey = Survey.find(params[:survey_id])
    if(@survey.no == nil)
      @survey.no = 0
    else
      @survey.no+=1
    end
    @survey.save
    redirect_to surveys_url
  end
  
  
  private
  def survey_params
    params.require(:survey).permit(:title, :question)
  end
  
end
